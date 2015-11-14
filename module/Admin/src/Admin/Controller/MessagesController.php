<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class MessagesController extends AbstractActionController
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
        $messageTable = $this->getMessageTable( );
        $messageTable->edit( "*" , [ "viewed" => 1 ] );
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'messages'      => $messageTable->fetchAll(),
        ];
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        
        $messageTable = $this->getMessageTable();
        $messageTable->delete( $id );
        
        return $this->response;
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Database\MessageTable 
     */
    private function getMessageTable()
    {
        return $this->getServiceLocator()->get('Application\Database\MessageTable');
    }
}

