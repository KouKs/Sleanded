<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Application\Database\TableModel\Post;
use Application\Helper\Messenger;

use Admin\Form\PostForm;

class IdeasheetController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->user = new Container('user');
        
        if( !$this->user->boolLogged ) {
            return $this->redirect()->toRoute('admin', array(
                'controller' => 'login'
            ));
        }
        
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        $this->layout("layout/admin");
        
        return [
            
        ];
    }


}

