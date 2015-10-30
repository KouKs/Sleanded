<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class WorkController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        $this->layout("layout/page");
        return [];
    }


}

