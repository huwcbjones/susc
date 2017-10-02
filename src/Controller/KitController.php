<?php

namespace SUSC\Controller;

use Cake\Mailer\Email;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use DateTime;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Form\KitBagForm;
use SUSC\Model\Entity\StaticContent;
use SUSC\Model\Table\ItemsTable;
use SUSC\Model\Table\OrdersTable;
use SUSC\Model\Table\StaticContentTable;

/**
 * Kit Controller
 *
 * @property OrdersTable $Orders
 * @property ItemsTable $Kit
 * @property StaticContentTable $Static
 * @property array $BasketData
 */
class KitController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Orders = TableRegistry::get('Orders');
        $this->Kit = TableRegistry::get('Items');
        $this->Static = TableRegistry::get('StaticContent');
        $this->loadKitBag();
    }

    protected function loadKitBag()
    {
        if (empty($this->BasketData)) $this->BasketData = $this->request->session()->read('Kit.Basket.Data');
        if (empty($this->BasketData)) $this->BasketData = array();

        foreach ($this->BasketData as $hash => $data) {
            $this->BasketData[$hash]['item'] = $this->Kit->get($data['id']);
        }
        $this->set('basketData', $this->BasketData);
        $this->set('basketTotal', $this->request->session()->read('Kit.Basket.Total'));
    }

    public function getACL()
    {
        if (in_array($this->request->getParam('action'), ['index', 'view', 'basket', 'orderComplete'])) return 'kit.*';
        if (in_array($this->request->getParam('action'), ['order', 'pay', 'orders', 'vieworder'])) return 'kit.order';

        return parent::getACL();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('kit', $this->Kit->find('published', ['order' => ['title' => 'ASC']]));
        $this->processKitBag();
        $this->loadKitBag();
    }

    protected function processKitBag()
    {
        $kitBagForm = new KitBagForm();
        $request = $this->request;

        if (!$request->is('post')) {
            return;
        }

        if ($request->getData('isRemove') != 0) {
            unset($this->BasketData[$request->getData('hash')]);
            $this->Flash->success('Successfully remove item from kit bag.');
        } else {

            if (!$kitBagForm->execute($request->getData())) {
                $this->Flash->error('There was an error adding that item to your basket.');
                return;
            }

            $id = $request->getData('id');
            $size = $request->getData('size');
            $quantity = $request->getData('quantity');
            $additionalInfo = $request->getData('additional_info');
            $item = $this->Kit->get($id);

            if ($this->request->getData('size') == '' && $item->sizeList != null) {
                $this->Flash->error('Please select a size!');
                return;
            }


            $data = [
                'id' => $id,
                'item' => $item,
                'size' => $size,
                'quantity' => $quantity,
                'additional_info' => $additionalInfo
            ];
            $hash = md5($id . $size . $quantity . $additionalInfo);
            $this->BasketData[$hash] = $data;
            $this->Flash->success('Successfully added item to basket.');

        }
        $total = 0;
        foreach ($this->BasketData as $hash => $data) {
            $total += $data['item']->price * $data['quantity'];
        }

        $request->session()->write('Kit.Basket.Total', $total);
        $request->session()->write('Kit.Basket.Data', $this->BasketData);
    }

    public function basket()
    {
        $this->set('title', 'My Basket');
        $this->processKitBag();
        $this->loadKitBag();
    }

    public function pay()
    {
        /** @var StaticContent $terms */
        $terms = $this->Static->find('KitTerms')->firstOrFail();
        $terms = (new GithubMarkdownExtended())->parse($terms->value);
        $this->set('terms', $terms);

        if (!$this->request->is('post')) return;
        if ($this->request->session()->read('Kit.Basket.Pay') === true) {
            $this->Flash->set('Order is already being processed...', ['element' => 'warn']);
            return;
        }


        if (!in_array($this->request->getData('payment'), ['bat', 'cash'])) {
            $this->Flash->error('Please select a payment method.');
            return;
        }

        $data = [
            'user_id' => $this->currentUser->id,
            'payment' => $this->request->getData('payment'),
            'placed' => (new DateTime())->getTimestamp(),
            'total' => 0,
            'items_orders' => []
        ];

        foreach ($this->BasketData as $hash => $d) {
            $item_data = [
                'item_id' => $d['id'],
                'size' => $d['size'],
                'quantity' => $d['quantity'],
                'additional_info' => $d['additional_info'],
                'price' => $d['item']->price,
                'subtotal' => $d['item']->price * $d['quantity']
            ];
            $data['total'] += $item_data['subtotal'];
            $data['items_orders'][] = $item_data;
        }
        if (count($data['items_orders']) == 0) {
            return $this->redirect(['_name' => 'order']);
        }
        $order = $this->Orders->newEntity($data);

        $this->request->session()->write('Kit.Basket.Pay', true);
        ignore_user_abort(true);
        set_time_limit(0);
        if ($this->Orders->save($order, ['associated' => ['ItemsOrders']])) {
            $this->Orders->loadInto($order, ['ItemsOrders' => 'Items']);
            $this->request->session()->write('Kit.Basket.Total', 0);
            $this->request->session()->write('Kit.Basket.Data', []);
            $email = new Email();
            $email
                ->setTo($this->currentUser->email_address, $this->currentUser->full_name)
                ->setSubject('Kit Order #' . $order->id)
                ->setTemplate('confirm_order')
                ->setViewVars(['order' => $order, 'user' => $this->currentUser])
                ->send();
            $this->request->session()->delete('Kit.Basket.Pay');
            return $this->redirect(['_name' => 'order_complete', 'order_number' => $order->id]);
        } else {
            $this->request->session()->delete('Kit.Basket.Pay');
            $this->Flash->error('There was an error whilst processing your order.');
        }
    }

    public function orders()
    {
        $query = $this->Orders
            ->find('user', ['user_id' => $this->currentUser->id])
            ->where(['is_cancelled' => false])
            ->order(['Orders.id' => 'DESC']);
        $orders = $this->paginate($query);

        $this->set(compact('items', 'orders'));
    }

    public function viewOrder($id = null)
    {
        $order = $this->Orders->find('ID', ['id' => $id])->firstOrFail();
        $this->set('order', $order);
    }

    public function orderComplete()
    {
        $this->set('orderNumber', $this->request->getQuery('order_number'));
    }

    public function view($slug)
    {
        $kit = $this->Kit->find('slug', ['slug' => $slug])->find('published')->first();
        if (empty($kit)) {
            throw new NotFoundException("Item not found.");
        }
        $this->set('kit', $kit);

        $this->processKitBag();
        $this->loadKitBag();
    }
}
