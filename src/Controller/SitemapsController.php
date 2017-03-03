<?php
/**
 * Author: Huw
 * Since: 03/03/2017
 */

namespace SUSC\Controller;

class SitemapsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index(){
        $this->set('data', array());
        $this->set('_serialize', false);
    }

    public function robots() {
        $this->set('_serialize', false);
        $this->viewBuilder()->setLayout('');
        $this->response->withType('txt');
        $this->render('robots');
    }
}