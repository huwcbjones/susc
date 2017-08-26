<?php

namespace SUSC\Controller;

use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use SUSC\Form\KitBagForm;

/**
 * Kit Controller
 *
 * @property \SUSC\Model\Table\KitItemsTable $Kit
 * @property array $BasketData
 */
class KitController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Kit = TableRegistry::get('KitItems');
        $this->loadKitBag();
    }

    protected function loadKitBag()
    {
        if (empty($this->BasketData)) $this->BasketData = $this->request->session()->read('Kit.Basket');
        if (empty($this->BasketData)) $this->BasketData = array();

        foreach ($this->BasketData as $k => $v) {
            $this->BasketData[$k]['kit'] = $this->Kit->find('id', ['id' => $k])->find('published')->first();
        }
        $this->set('basketData', $this->BasketData);
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

    public function basket()
    {
        $this->set('title', 'My Basket');
        $this->processKitBag();
        $this->loadKitBag();
    }

    public function order()
    {

    }

    public function viewOrder()
    {

    }

    public function order_complete()
    {

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
        if ($request->getData('isRemove') == 0) {
            $this->BasketData[$id] = [
                'id' => $id,
                'kit' => $this->Kit->find('id', ['id' => $id])->find('published')->first(),
                'size' => $request->getData('size')
            ];
            $this->Flash->success('Successfully added item to basket.');
        } else {
            unset($this->BasketData[$id]);
            $this->Flash->success('Successfully remove item from kit bag.');
        }

        $request->session()->write('Kit.Basket', $this->BasketData);
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
