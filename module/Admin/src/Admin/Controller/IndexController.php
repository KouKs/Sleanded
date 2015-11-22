<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class IndexController extends AbstractActionController
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
            'message'        => isset( $message ) ? $message : null,
            'messages'       => $this->getMessageTable()->select("viewed=0"),
            'assignedTickets'=> $this->getTicketTable()->select( 
                    array( "assigned_to=".$this->user->id , "resolved=0"),
                    null,
                    "projects",
                    "projects.id = tickets.project_id",
                    array("project_name" => "name"),
                    "project_id DESC, importance DESC, time DESC"                    
            ),
            'pendingTickets' => $this->getTicketTable()->select(
                    "assigned_to=0",
                    null,
                    "projects",
                    "projects.id = tickets.project_id",
                    array("project_name" => "name"),
                    "project_id DESC, importance DESC, time DESC"
            ),
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
        return $this->getServiceLocator()->get('Application\Database\MessageTable');
    }
    
    /**
     * Returns an isntance of ticket table
     * @return Application\Model\TicketTable 
     */
    private function getTicketTable()
    {
        return $this->getServiceLocator()->get('Application\Database\TicketTable');
    }
}

