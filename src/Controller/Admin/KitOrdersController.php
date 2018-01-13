<?php
/**
 * Author: Huw
 * Since: 07/09/2017
 */

namespace SUSC\Controller\Admin;


use Aura\Intl\Exception;
use Cake\Http\Response;
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
        $this->loadComponent('Paginator');
        $this->Orders = TableRegistry::get('Orders');
        $this->ItemsOrders = TableRegistry::get('ItemsOrders');
        $this->ProcessedOrders = TableRegistry::get('ProcessedOrders');
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.kit-orders.*';
        if ($this->request->getParam('action') == 'sendReminderEmails') return 'admin.kit-orders.remind';
        if (in_array($this->request->getParam('action'), ['paid', 'ordered', 'arrived', 'collected'])) {
            return 'admin.kit-orders.status';
        }
        if (in_array($this->request->getParam('action'), ['batches'])) {
            return 'admin.kit-orders.process';
        }
        return parent::getACL();
    }

    public function index()
    {
        $options = [
            'order' => ['id' => 'DESC'],
            'contain' => ['Users', 'ItemsOrders' => 'ProcessedOrders'],
            'sortWhitelist' => [
                'id',
                'Users.last_name',
                'placed',
                'total',
                'payment',
                'paid'
            ]
        ];

        if (($user_id = $this->request->getQuery('user_id')) !== null) {
            $options['finder'] = [
                'user' => ['user_id' => $user_id]
            ];

        }
        $orders = $this->paginate($this->Orders, $options);

        $this->set('orders', $orders);
    }

    public function collections()
    {
        $options = [
            'order' => ['created' => 'DESC'],
            'finder' => 'collections',
            'sortWhitelist' => [
                'order_id',
                'Items.title',
                'size',
                'colour',
                'additional_info',
                'Orders.paid'
            ]
        ];

        if (($user_id = $this->request->getQuery('user_id')) !== null) {
            $options['finder'] = [
                'collections' => ['user_id' => $user_id]
            ];
        }

        $items = $this->paginate($this->ItemsOrders, $options);

        $this->set('items', $items);
    }

    public function view($id = null)
    {
        $order = $this->Orders->find('id', ['id' => $id])->firstOrFail();

        $this->set(compact('order'));
    }

    /**
     * Cancels an order
     *
     * @param string|null $id ID of order to cancel
     * @return Response|null
     */
    public function cancel($id = null)
    {
        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');

        /** @var Order $order */
        $order = $this->Orders->find('id', ['id' => $id])->firstOrFail();

        // Prevent cancelling and order that has items in a batch that has been ordered
        if ($order->ordered_left != count($order->items)) {
            $this->Flash->error('Cannot cancel order - some items have already been ordered!');
            return $this->redirect($this->referer());
        }

        // Soft-delete the order
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

    /**
     * Marks an order as paid
     * @param string|null $id ID of Order to mark as paid
     * @return Response|null
     */
    public function paid($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'index']);
        }

        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');

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

    /**
     * Mark a processed order as ordered
     * @param string|null $id ID of processed order
     * @return Response|null
     */
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

    /**
     * Mark a ProcessedOrder as arrived
     * @param string|null $id ID of Processed Order
     * @return Response|null
     */
    public function arrived($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect($this->referer());
        }

        /** @var ProcessedOrder $order */
        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');
        $order = $this->ProcessedOrders->get($id);

        // If the order has already arrived, don't do anything
        if ($order->is_arrived) return $this->redirect($this->referer());
        $order->arrived = new DateTime();

        if ($this->ProcessedOrders->save($order)) {

            // Fetch orders and items that are in this batch
            $orders = $this->Orders->find('batchID', ['id' => $order->id])->toArray();

            // Email out each order
            foreach ($orders as $order) {
                $email = new Email();
                $email
                    ->setTo($order->user->email_address, $order->user->full_name)
                    ->setSubject('Item Arrival - Order #' . $order->id)
                    ->setTemplate('order_collection')
                    ->setViewVars(['order' => $order, 'user' => $order->user])
                    ->send();
            }
            $this->Flash->success('Batch marked as arrived. Users have been emailed to collect their items.');
        } else {
            $this->Flash->error('Failed to mark the batch as arrived!');
        }
        return $this->redirect($this->referer());
    }

    /**
     * Mark an Item (ItemsOrder) as collected
     * @param string|null $id UUID of Item
     * @return Response|null
     */
    public function collected($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect($this->referer());
        }

        /** @var ItemsOrder $item */
        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');
        $item = $this->ItemsOrders->find('id', ['id' => $id])->firstOrFail();

        // If the item is already collected, don't do anything
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

    /**
     * Display all processed orders, or a single processed.
     * If $id is null, all processed orders will be displayed.
     *
     * @param string|null $id ID of processed order to display
     */
    public function batches($id = null)
    {
        if ($id == null) {
            $orders = $this->paginate($this->ProcessedOrders, ['order' => ['created' => 'DESC'], 'contain' => ['Users', 'ItemsOrders' => ['Orders', 'Items']]]);

            $this->set('orders', $orders);
            return;
        }

        /** @var ProcessedOrder $order */
        $order = $this->ProcessedOrders->find('assoc')->where(['id' => $id])->firstOrFail();
        $this->Paginator->setConfig('maxLimit', $order->item_count);
        $this->Paginator->setConfig('limit', $order->item_count);
        $options = [
            'order' => ['order_id' => 'ASC'],
            'finder' => [
                'batch' => ['id' => $id]
            ],
            'maxLimit' => $order->item_count,
            'limit' => $order->item_count,
            'sortWhitelist' => [
                'id',
                'Users.last_name',
                'item_id',
                'additional_info',
                'size',
                'price',
                'quantity',
                'subtotal',
                'Orders.paid',
                'collected'
            ]
        ];
        $items = $this->Paginator->paginate($this->ItemsOrders, $options);
        $this->set('order', $order);
        $this->set('items', $items);
        $this->viewBuilder()->setTemplate('view_batch');
    }

    /**
     * Kit Configuration Page
     */
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

    /**
     * Batch order processing
     * @return Response|null
     */
    public function process()
    {
        $items = TableRegistry::get('Items')->find('all')->toArray();
        $this->set('items', $items);

        if (!$this->request->is(['patch', 'post', 'put'])) {
            return null;
        }

        $this->loadComponent('KitProcess');

        try {
            $this->KitProcess->process();
            return $this->redirect(['action' => 'processed-orders']);
        } catch (Exception $ex) {

        }
    }

    /**
     * Downloads a processed order zip file
     * @param string|null $id ID of processed order
     * @return Response
     */
    public function download($id = null)
    {
        $this->loadComponent('KitProcess');

        // If the download doesn't exist, create the download
        if (!$this->KitProcess->isDownloadExist($id)) {
            $this->KitProcess->createDownload($id);
        }

        // Send the download
        $response = $this->response
            ->withType('application/zip')
            ->withDownload($this->KitProcess->getZipFileName())
            ->withFile($this->KitProcess->getZipFilePath());
        return $response;
    }

    public function sendReminderEmails()
    {
        if (!$this->request->is(['patch', 'post', 'put'])) return $this->redirect($this->referer());

        $orders = $this->Orders->find()
            ->contain(['Users'])
            ->where([
                'Orders.placed <' => new DateTime('-3 days'),
                'OR' => [
                    'Orders.last_reminder <' => new DateTime('-3 days'),
                    'Orders.last_reminder IS ' => null
                ],
                'is_cancelled' => false,
                'paid IS' => null
            ])->toArray();

        $email = new Email();
        $email
            ->setSubject('SUSC Kit Order Reminder')
            ->setTemplate('order_reminder');

        $now = new DateTime();
        foreach ($orders as &$order) {
            $order->last_reminder = $now;
            $email
                ->setTo($order->user->email_address, $order->user->full_name)
                ->setViewVars(['order' => $order, 'user' => $order->user])
                ->send();
        }

        $this->Orders->saveMany($orders);

        $this->Flash->success('Sent ' . count($orders) . ' reminder emails.');
        return $this->redirect($this->referer());

    }
}