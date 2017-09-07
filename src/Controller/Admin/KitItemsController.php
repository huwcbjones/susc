<?php
/**
 * Author: Huw
 * Since: 05/09/2017
 */

namespace SUSC\Controller\Admin;


use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
use SUSC\Controller\AppController;
use SUSC\Model\Table\ItemsTable;
use Zend\Diactoros\UploadedFile;

/**
 * Class KitItemsController
 * @package SUSC\Controller
 *
 * @property AuthComponent $Auth
 * @property ItemsTable $Items
 */
class KitItemsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Items = TableRegistry::get('Items');
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.kit-items.*';
        return parent::getACL();
    }

    public function index()
    {
        $items = $this->paginate($this->Items);

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    public function add()
    {

    }

    public function view($id = null)
    {
        $item = $this->Items->get($id);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function edit($id = null)
    {
        $item = $this->Items->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $item->setAccess('image', false);
            $item = $this->Users->patchEntity($item, $this->request->getData());
            if(count($this->request->getUploadedFiles()) == 1){
                /** @var UploadedFile $image */
                $image = $this->request->getUploadedFiles()['image'];
                if($image->getError() == UPLOAD_ERR_OK) {
                    $image->moveTo(WWW_ROOT . DS . 'images' . DS . 'store' . DS . 'kit' . DS . $item->id . '.jpg');
                    $item->image = $item->id . '.jpg';
                }
            }
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $item = $this->Items->get($id);

        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}