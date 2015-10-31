<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MessagesController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout("layout/admin");
        $messageTable = $this->getMessageTable( );
        $messageTable->edit( "*" , [ "viewed" => 1 ] );
        
        return [
            'messages' => $messageTable->fetchAll(),
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

