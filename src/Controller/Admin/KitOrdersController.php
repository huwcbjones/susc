<?php
/**
 * Author: Huw
 * Since: 07/09/2017
 */

namespace SUSC\Controller\Admin;


use Cake\ORM\TableRegistry;
use DateTime;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\Order;
use SUSC\Model\Table\OrdersTable;

/**
 * Class KitOrdersController
 * @package SUSC\Controller\Admin
 *
 * @property OrdersTable $Orders
 */
class KitOrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Orders = TableRegistry::get('Orders');
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.kit-orders.*';
        if (in_array($this->request->getParam('action'), ['paid', 'ordered', 'collected'])) {
            return 'admin.kit-orders.status';
        }
        return parent::getACL();
    }

    public function index()
    {
        $orders = $this->paginate($this->Orders, ['order' => ['id' => 'DESC'], 'contain' => ['Users']]);

        $this->set('orders', $orders);
    }

    public function paid($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'index']);
        }

        /** @var Order $order */
        $order = $this->Orders->get($id);
        $order->paid = ($order->paid == null) ? new DateTime() : null;

        if ($this->Orders->save($order)) {
            $this->Flash->success('Order paid status toggled.');
        } else {
            $this->Flash->error('Failed to toggle order paid status.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function ordered($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'index']);
        }

        /** @var Order $order */
        $order = $this->Orders->get($id);
        $order->ordered = ($order->ordered == null) ? new DateTime() : null;

        if ($this->Orders->save($order)) {
            $this->Flash->success('Order status toggled.');
        } else {
            $this->Flash->error('Failed to toggle order status.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function collected($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'index']);
        }

        /** @var Order $order */
        $order = $this->Orders->get($id);
        $order->collected = ($order->collected == null) ? new DateTime() : null;

        if ($this->Orders->save($order)) {
            $this->Flash->success('Order collection status toggled.');
        } else {
            $this->Flash->error('Failed to toggle order collection status.');
        }
        return $this->redirect(['action' => 'index']);
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
            foreach($this->request->getData()['kit-orders'] as $k => $v){
                if($v == '') $v = null;
                $config[$k]->value = $v;
            }
            $result = $this->Config->saveMany($config);
            if($result !== false){
                $config = $result;
                $this->Flash->success('Config saved!');
            } else {
                $this->Flash->error('Config could not be saved!');
            }
        }

        $this->set(compact('items', 'config'));
    }

    public function process(){
        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }


    }
}