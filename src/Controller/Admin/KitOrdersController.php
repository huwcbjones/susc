<?php
/**
 * Author: Huw
 * Since: 07/09/2017
 */

namespace SUSC\Controller\Admin;


use Aura\Intl\Exception;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use DateTime;
use SUSC\Controller\AppController;
use SUSC\Controller\Component\KitProcessComponent;
use SUSC\Model\Entity\ItemsOrder;
use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\ProcessedOrder;
use SUSC\Model\Table\ItemsOrdersTable;
use SUSC\Model\Table\OrdersTable;
use SUSC\Model\Table\ProcessedOrdersTable;

/**
 * Class KitOrdersController
 * @package SUSC\Controller\Admin
 *
 * @property KitProcessComponent $KitProcess
 * @property OrdersTable $Orders
 * @property ItemsOrdersTable $ItemsOrders
 * @property ProcessedOrdersTable $ProcessedOrders
 */
class KitOrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Orders = TableRegistry::get('Orders');
        $this->ItemsOrders = TableRegistry::get('ItemsOrders');
        $this->ProcessedOrders = TableRegistry::get('ProcessedOrders');
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.kit-orders.*';
        if (in_array($this->request->getParam('action'), ['paid', 'ordered', 'arrived', 'collected'])) {
            return 'admin.kit-orders.status';
        }
        if (in_array($this->request->getParam('action'), ['processedOrders'])) {
            return 'admin.kit-orders.process';
        }
        return parent::getACL();
    }

    public function index()
    {
        $orders = $this->paginate($this->Orders, ['order' => ['id' => 'DESC'], 'contain' => ['Users', 'ItemsOrders' => 'ProcessedOrders']]);

        $this->set('orders', $orders);
    }

    public function view($id = null)
    {
        $order = $this->Orders->find('id', ['id' => $id])->firstOrFail();

        $this->set(compact('order'));
    }

    public function cancel($id = null)
    {
        /** @var Order $order */
        $order = $this->Orders->find('id', ['id' => $id])->firstOrFail();

        if ($order->ordered_left != count($order->items)) {
            $this->Flash->error('Cannot cancel order - some items have already been ordered!');
            return $this->redirect($this->referer());
        }

        $order->is_cancelled = true;
        if ($this->Orders->save($order)) {
            $email = new Email();
            $email
                ->setTo($order->user->email_address, $order->user->full_name)
                ->setSubject('Cancelled Kit Order #' . $order->id)
                ->setTemplate('order_cancel')
                ->setViewVars(['orderNumber' => $order->id, 'user' => $order->user])
                ->send();
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error('Failed to cancel order!');
        }
    }

    public function paid($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'index']);
        }

        /** @var Order $order */
        $order = $this->Orders->find('ID', ['id' => $id])->firstOrFail();
        if ($order->is_paid) {
            $this->Flash->success('Order has already been marked as paid.');
            return $this->redirect(['action' => 'index']);
        }

        $order->paid = new DateTime();

        if ($this->Orders->save($order)) {
            $email = new Email();
            $email
                ->setTo($order->user->email_address, $order->user->full_name)
                ->setSubject('Payment Received - Order #' . $order->id)
                ->setTemplate('order_payment')
                ->setViewVars(['order' => $order, 'user' => $order->user])
                ->send();

            $this->Flash->success('Order has been marked as paid.');
        } else {
            $this->Flash->error('Failed to mark order as paid!');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function ordered($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect($this->referer());
        }

        /** @var ProcessedOrder $order */
        $order = $this->ProcessedOrders->get($id);
        $order->ordered = ($order->ordered == null) ? new DateTime() : null;

        if ($this->ProcessedOrders->save($order)) {
            if ($order->is_ordered) {
                $this->Flash->success('Marked batch as ordered.');
            } else {
                $this->Flash->success('Marked batch as <strong>not</strong> ordered.', ['escape' => false]);
            }
        } else {
            $this->Flash->error('Failed to set batch order status.');
        }
        return $this->redirect($this->referer());
    }

    public function arrived($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect($this->referer());
        }

        /** @var ProcessedOrder $order */
        if ($id === null) $id = $this->request->getData('id');
        $order = $this->ProcessedOrders->get($id);
        $order->arrived = ($order->arrived == null) ? new DateTime() : null;

        if ($this->ProcessedOrders->save($order)) {
            // TODO: Send email to users to say item is ready for collection

            $this->Flash->success('Batch marked as arrived. Users have been emailed to collect their items.');
        } else {
            $this->Flash->error('Failed to mark the batch as arrived!');
        }
        return $this->redirect($this->referer());
    }

    public function collected($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect($this->referer());
        }

        /** @var ItemsOrder $item */
        $item = $this->ItemsOrders->find('id', ['id' => $id])->firstOrFail();
        if ($item->is_collected) return $this->redirect($this->referer());

        $item->collected = new DateTime();

        if ($this->ItemsOrders->save($item)) {
            $email = new Email();
            $email
                ->setTo($item->order->user->email_address, $item->order->user->full_name)
                ->setSubject('Collected Item: ' . $item->item->title)
                ->setTemplate('item_collected')
                ->setViewVars(['item' => $item, 'user' => $item->order->user])
                ->send();

            $this->Flash->success('Item marked as collected.');
        } else {
            $this->Flash->error('Failed mark item as collected!');
        }
        return $this->redirect($this->referer());
    }

    public function processedOrders($id = null)
    {
        if ($id == null) {
            $orders = $this->paginate($this->ProcessedOrders, ['order' => ['created' => 'DESC'], 'contain' => ['Users', 'ItemsOrders' => ['Orders', 'Items']]]);

            $this->set('orders', $orders);
            return;
        }

        $order = $this->ProcessedOrders->get($id);
        $this->set('order', $order);
        $this->viewBuilder()->setTemplate('view_processed_orders');
    }

    public function config()
    {
        $items = [];
        foreach (TableRegistry::get('Items')->find('all')->all() as $item) {
            $items[$item->id] = $item->title;
        }

        $config_items = [
            'athletics-singlet-ladies',
            'athletics-singlet-mens',
            'compression-shorts-ladies',
            'compression-shorts-mens',
            'crop-top-(sports-bra)',
            'ladies-hoodie',
            'ladies-tracksuit-trousers',
            'ladies-training-shirt',
            'ladies-training-shorts',
            'mens-hoodie',
            'mens-tracksuit-trousers',
            'mens-training-shirt',
            'mens-training-shorts'
        ];
        $config = [];
        foreach ($config_items as $i) {
            $config[$i] = $this->Config->get('kit-orders.' . $i);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            foreach ($this->request->getData()['kit-orders'] as $k => $v) {
                if ($v == '') $v = null;
                $config[$k]->value = $v;
            }
            $result = $this->Config->saveMany($config);
            if ($result !== false) {
                $config = $result;
                $this->Flash->success('Config saved!');
            } else {
                $this->Flash->error('Config could not be saved!');
            }
        }

        $this->set(compact('items', 'config'));
    }

    public function process()
    {
        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }

        $this->loadComponent('KitProcess');

        try {
            $this->KitProcess->process();
            return $this->redirect(['action' => 'processed-orders']);
        } catch (Exception $ex) {

        }
    }

    public function download($id = null)
    {
        $this->loadComponent('KitProcess');

        if (!$this->KitProcess->isDownloadExist($id)) {
            $this->KitProcess->createDownload($id);
        }
        $response = $this->response
            ->withType('application/zip')
            ->withDownload($this->KitProcess->getZipFileName())
            ->withFile($this->KitProcess->getZipFilePath());
        return $response;
    }
}