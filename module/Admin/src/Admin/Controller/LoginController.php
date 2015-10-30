<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout( "layout/empty" );
        
        return [];
    }


}

