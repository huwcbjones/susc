<?php
/**
 * Author: Huw
 * Since: 05/09/2017
 */

namespace SUSC\Controller\Admin;


use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\Item;
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
        $items = $this->paginate($this->Items, ['order' => ['title' => 'ASC']]);

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    public function add()
    {
        $item = $this->Items->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            $item->slug = Text::slug(strtolower($item->title));


            $result = $this->Items->getConnection()->transactional(function () use ($item) {
                if (!$this->Items->save($item)) {
                    return false;
                }

                if (!array_key_exists('image', $this->request->getUploadedFiles())) {
                    return true;
                }

                /** @var UploadedFile $image */
                $image = $this->request->getUploadedFiles()['image'];
                if ($image->getError() == UPLOAD_ERR_OK) {
                    $image->moveTo(WWW_ROOT . DS . 'images' . DS . 'store' . DS . 'kit' . DS . $item->id . '.jpg');
                    $item->image = true;
                }

                return $this->Items->save($item);

            });
            if ($result) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function view($id = null)
    {
        $item = $this->Items->get($id);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function edit($id = null)
    {
        /** @var Item $item */
        $item = $this->Items->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $item->setAccess('image', false);
            $item = $this->Users->patchEntity($item, $this->request->getData());
            if (count($this->request->getUploadedFiles()) == 1) {
                /** @var UploadedFile $image */
                $image = $this->request->getUploadedFiles()['image'];
                if ($image->getError() == UPLOAD_ERR_OK) {
                    $image->moveTo(WWW_ROOT . DS . 'images' . DS . 'store' . DS . 'kit' . DS . $item->id . '.jpg');
                    $item->image = true;
                }
            }
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
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
        $this->Items->loadInto($item, ['ItemsOrders']);
        if(count($item->items_orders) != 0) {
            $item->status = false;
            if($this->Items->save($item)) {
                $this->Flash->set(__('Cannot delete item as there are orders attached to this item. Item has been disabled instead.'),['element' => 'warn']);
            } else {
                $this->Flash->error(__('Cannot delete item as there are orders attached to this item. Failed to disable item!'));
            }
            return $this->redirect($this->referer());
        }


        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}