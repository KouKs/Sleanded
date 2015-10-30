<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
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
    
    public function loginAction()
    {
        $this->layout( "layout/empty" );
        
        return [];
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

