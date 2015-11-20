<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ProjectForm;

class ProjectsController extends AbstractActionController
{

    private $user;
    
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
            'message'       => isset( $message ) ? $message : null,
        ];
    }
    public function addAction()
    {
        $this->layout("layout/admin");
        $form = new ProjectForm();
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
        ];
    }

}

