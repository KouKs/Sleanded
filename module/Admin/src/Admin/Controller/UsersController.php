<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\NewUserForm;

class UsersController extends AbstractActionController
{
    
    private $user;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->user = new Container('user');
        
        if( !$this->user->boolLogged )
        {
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
            'users'         => $this->getUserTable()->fetchAll( ),
        ];
    }
    
    public function addAction( ) {
        $this->layout("layout/admin");
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => new NewUserForm
        ];
    }

    /**
     * Returns an isntance of users table
     * @return Admin\Model\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Admin\Model\UserTable');
    }
}