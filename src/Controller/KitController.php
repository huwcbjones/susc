<?php

namespace SUSC\Controller;

use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use SUSC\Form\KitBagForm;

/**
 * Kit Controller
 *
 * @property \SUSC\Model\Table\KitTable $Kit
 * @property array $KitBagData
 */
class KitController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Kit = TableRegistry::get('Kit');

        $this->KitBagData = $this->request->session()->read('Kit.KitBag');
        if (empty($this->KitBagData)) $this->KitBagData = array();

        foreach ($this->KitBagData as $k => $v) {
            $this->KitBagData[$k]['kit'] = $this->Kit->find('id', ['id' => $k])->find('published')->first();
        }
        $this->set('kitBagData', $this->KitBagData);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('kit', $this->Kit->find('published'));
    }

    public function view($slug)
    {
        $kitBagForm = new KitBagForm();
        $request = $this->request;
        if ($request->is('post')) {
            if ($kitBagForm->execute($request->getData())) {
                $id = $request->getData('id');
                if ($request->getData('isRemove') == 0) {
                    $this->KitBagData[$id] = [
                        'id' => $id,
                        'size' => $request->getData('size')
                    ];
                    $this->Flash->success('Successfully added item to kit bag.');
                } else {
                    unset($this->KitBagData[$id]);
                    $this->Flash->success('Successfully remove item from kit bag.');
                }
                $request->session()->write('Kit.KitBag', $this->KitBagData);
            } else {
                $this->Flash->error('There was an error adding that item to your kit bag.');
            }
        }

        $kit = $this->Kit->find('slug', ['slug' => $slug])->find('published')->first();
        if (empty($kit)) {
            throw new NotFoundException("Kit not found.");
        }
        $this->set('kit', $kit);
    }
}
