<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UsersController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout("layout/admin");
        return [];
    }


}