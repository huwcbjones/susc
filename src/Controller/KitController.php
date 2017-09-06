<?php

namespace SUSC\Controller;

use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use DateTime;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Form\KitBagForm;
use SUSC\Model\Entity\StaticContent;
use SUSC\Model\Table\KitItemsTable;
use SUSC\Model\Table\KitOrdersTable;
use SUSC\Model\Table\StaticContentTable;

/**
 * Kit Controller
 *
 * @property KitOrdersTable $Orders
 * @property KitItemsTable $Kit
 * @property StaticContentTable $Static
 * @property array $BasketData
 */
class KitController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Orders = TableRegistry::get('KitOrders');
        $this->Kit = TableRegistry::get('KitItems');
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
        $this->set('kit', $this->Kit->find('published'));
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

        if (!$kitBagForm->execute($request->getData())) {
            $this->Flash->error('There was an error adding that item to your basket.');
            return;
        }

        $id = $request->getData('id');
        $size = $request->getData('size');
        $quantity = $request->getData('quantity');
        $additionalInfo = $request->getData('additional_info');
        if ($request->getData('isRemove') == 0) {
            $data = [
                'id' => $id,
                'item' => $this->Kit->find('id', ['id' => $id])->find('published')->first(),
                'size' => $size,
                'quantity' => $quantity,
                'additional_info' => $additionalInfo
            ];
            $hash = md5($id . $size . $quantity . $additionalInfo);
            $this->BasketData[$hash] = $data;
            $this->Flash->success('Successfully added item to basket.');
        } else {
            unset($this->BasketData[$request->getData('hash')]);
            $this->Flash->success('Successfully remove item from kit bag.');
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

        $total = 0;
        foreach($this->BasketData as $hash=>$d){
            $total += $d['quantity'] * $d['item']->price;
        }

        $data = [
            'user_id' => $this->currentUser->id,
            'payment' => $this->request->getData('payment'),
            'date_ordered' => (new DateTime())->getTimestamp(),
            'total' => $total,
            'kit_items_order' => []
        ];

        $order = $this->Orders->newEntity($data);

        $result = $this->Orders->getConnection()->transactional(function () use ($order, $data) {


            if (!$this->Orders->save($order)) {
                return false;
            }
            $items = [];

            foreach ($this->BasketData as $hash => $d) {
                $item = $this->Kit->get($d['id']);

                $item->_joinData = new Entity([
                    'order_id' => $order->id,
                    'kit_id' => $d['id'],
                    'size' => $d['size'],
                    'quantity' => $d['quantity'],
                    'additional_info' => $d['additional_info'],
                    'price' => $d['item']->price,
                    'subtotal' => $d['item']->price * $d['quantity']
                ]);
                $order->total += $item->_joinData->subtotal;
                $items[] = $item;
            }
            $this->Orders->KitItems->link($order, $items);

            $this->request->session()->write('Kit.Basket.Total', 0);
            $this->request->session()->write('Kit.Basket.Data', []);
            return true;
        });

        if ($result) {
            return $this->redirect(['_name' => 'order_complete', 'order_number' => $order->id]);
        } else {
            $this->Flash->error('There was an error whilst processing your order.');

        }
    }

    public function orders()
    {
        $orders = $this->paginate($this->Orders, [
            'finder' => [
                'user' => ['user_id' => $this->currentUser->id]
            ],
            'order' => ['date_ordered' => 'DESC']
        ]);
        //$this->Orders->find('user', ['user_id' => $this->currentUser->id]);

        $this->set('orders', $orders);
    }

    public function viewOrder($id = null)
    {

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
