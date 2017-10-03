<?php

namespace SUSC\Controller;

use Aura\Intl\Exception;
use Cake\Cache\Cache;
use Cake\Controller\Component\AuthComponent;
use Cake\Network\Exception\ServiceUnavailableException;
use Cake\ORM\TableRegistry;
use PHPThumb\GD;
use SUSC\Model\Entity\Image;
use SUSC\Model\Table\GalleriesTable;

/**
 * Galleries Controller
 *
 * @property GalleriesTable $Galleries
 * @property AuthComponent $Auth
 */
class GalleriesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        // Get table instance
        $this->Galleries = TableRegistry::get('Galleries');

        // Set auth
        $this->Auth->allow();
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('galleries', $this->Galleries->find('gallery')->toArray());
    }

    public function thumbnail($id)
    {
        /** @var Image $image */
        $image = TableRegistry::get('Images')->get($id);

        $this->autoRender = true;
        $response = $this->response
            ->withType($image->extension)
            ->withBody(Cache::remember('image-thumb-' . $image->id, function () use ($image) {
                // Cache thumbnail using thumbnail rule (we are dynamically creating the thumbnail using php)
                try {
                    $thumb = new GD($image->full_path);
                    $thumb->resize(500, 500);
                    $thumb->show(true);
                } catch (Exception $e){
                    throw new ServiceUnavailableException($e);
                }
            }, 'thumbnail'));
        return $response;
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gallery = $this->Galleries->newEntity();
        if ($this->request->is('post')) {
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->getData());
            if ($this->Galleries->save($gallery)) {
                $this->Flash->success(__('The gallery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gallery could not be saved. Please, try again.'));
        }
        $thumbnailImage = $this->Galleries->ThumbnailImage->find('list', ['limit' => 200]);
        $images = $this->Galleries->Images->find('list', ['limit' => 200]);
        $this->set(compact('gallery', 'thumbnailImage', 'images'));
        $this->set('_serialize', ['gallery']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Gallery id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => ['Images']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->getData());
            if ($this->Galleries->save($gallery)) {
                $this->Flash->success(__('The gallery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gallery could not be saved. Please, try again.'));
        }
        $thumbnailImage = $this->Galleries->ThumbnailImage->find('list', ['limit' => 200]);
        $images = $this->Galleries->Images->find('list', ['limit' => 200]);
        $this->set(compact('gallery', 'thumbnailImage', 'images'));
        $this->set('_serialize', ['gallery']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Gallery id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gallery = $this->Galleries->get($id);
        if ($this->Galleries->delete($gallery)) {
            $this->Flash->success(__('The gallery has been deleted.'));
        } else {
            $this->Flash->error(__('The gallery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
