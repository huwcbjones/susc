<?php
namespace SUSC\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use phpthumb;

/**
 * Galleries Controller
 *
 * @property \SUSC\Model\Table\GalleriesTable $Galleries
 */
class GalleriesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Galleries = TableRegistry::get('Galleries');
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('galleries', $this->Galleries->findGallery('published'));
    }

    public function thumbnail($id)
    {
        $images = TableRegistry::get('Images')->find('id', [$id]);
        if ($images->count() != 1) {
            return new NotFoundException();
        }
        $image = $images->first();
        $this->autoRender = false;
        $this->response->type($image->extension);

        $this->response->body(Cache::remember('image-thumb-' . $image->id, function () use ($image){
            $pt = new phpthumb();

            $pt->config_disable_debug = !Configure::read('debug');

            $pt->setParameter('w', 500);
            $pt->setSourceFilename(WWW_ROOT . $image->path);

            if ($pt->GenerateThumbnail()) {
                $pt->RenderOutput();
                return $pt->outputImageData;
            } else {
                throw new NotFoundException();
            }

        }, 'thumbnail'));
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
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
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
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
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
