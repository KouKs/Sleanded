<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {

        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }


}

