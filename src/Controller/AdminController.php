<?php
/**
 * Author: Huw
 * Since: 24/06/2016
 */

namespace SUSC\Controller;


class AdminController extends AppController
{
    function index()
    {
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') {
            return 'admin.*';
        }
        return parent::getACL();
    }


}