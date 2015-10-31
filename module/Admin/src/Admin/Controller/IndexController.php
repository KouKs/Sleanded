<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{

    private $logged;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->logged = new Container('user');
        
        if( !$this->logged->boolLogged ) {
            return $this->redirect()->toRoute('admin', array(
                'controller' => 'index'
            ));
        }
        
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        $this->layout("layout/admin");
        $messageTable = $this->getMessageTable( );
        
        return [
            'messages' => $messageTable->select("viewed=0"),
        ];
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Model\MessageTable 
     */
    private function getMessageTable()
    {
        return $this->getServiceLocator()->get('Application\Model\MessageTable');
    }
}

