<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ProjectForm;
use Admin\Form\TicketForm;

use Application\Helper\Messenger;
use Application\Database\TableModel\Project;
use Application\Database\TableModel\Ticket;

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
            'projects'      => $this->getProjectTable()->fetchAll(),
        ];
    }
    
    public function addAction()
    {
        $this->layout("layout/admin");
        $form = new ProjectForm();
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $p = new Project();
                $p->exchangeArray( $request->getPost() );
                $this->getProjectTable()->add( $p );
                
                $message = [ "Project has been successfully added" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
        ];
    }
    
    public function editAction()
    {
        $this->layout("layout/admin");
        $id = $this->params('id');
        $form = new ProjectForm();
        $request = $this->getRequest();
        $projectTable = $this->getProjectTable();
        $p = new Project(  );
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $p->exchangeArray( $request->getPost() );
                $projectTable->edit( $id , $p->toArray() );
                
                $message = [ "Project has been successfully edited" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        $p->exchangeArray( $projectTable->select("id=".$id)->toArray()[0] );
        $form->setData( $p->toArray() );
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
        ];
    }
    
    public function viewAction()
    {
        $this->layout("layout/admin"); 
        $id = $this->params('id');
        $form = new TicketForm( $this->user->id , $id );
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $t = new Ticket();
                $t->exchangeArray( $request->getPost() );
                $this->getTicketTable()->add( $t );
                
                $message = [ "Ticket has been successfully added" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        return [
            'message'      => isset( $message ) ? $message : null,
            'project'      => $this->getProjectTable()->select("id=". $id),
            'tickets'      => $this->getTicketTable()->select( 
                'project_id=' . $id,
                null,
                'users',
                'tickets.assigned_to = users.id',
                'full_name',
                'resolved ASC, importance DESC, time DESC'
            ),
            'form'         => $form,
            'user_id'      => $this->user->id,
        ];
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        
        $projectTable = $this->getProjectTable();
        $projectTable->delete( $id );
        
        return $this->response;
    }
    
    public function changeprogressAction()
    {
        $id = $this->params('id');
        $progress = $this->params('seo');
        
        $projectTable = $this->getProjectTable();
        $projectTable->edit( $id , [ 'progress' => $progress ] );
        
        return $this->response;
    }

    public function changeresolvedAction()
    {
        $id = $this->params('id');
        $resolved = $this->params('seo');
        
        $ticketTable = $this->getTicketTable();
        $ticketTable->edit( $id , [ 'resolved' => $resolved ] );
        
        return $this->response;
    }
    
    public function assignticketAction()
    {
        $id = $this->params('id');
        $assignTo = $this->params('seo');
        
        $ticketTable = $this->getTicketTable();
        $ticketTable->edit( $id , [ 'assigned_to' => $assignTo ] );
        
        return $this->response;
    }
    
    public function deleteticketAction()
    {
        $id = $this->params('id');
        
        $ticketTable = $this->getTicketTable();
        $ticketTable->delete( $id );
        
        return $this->response;
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of project table
     * @return Application\Database\ProjectTable 
     */
    private function getProjectTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ProjectTable');
    }
    
    /**
     * Returns an isntance of ticket table
     * @return Application\Database\TicketTable 
     */
    private function getTicketTable()
    {
        return $this->getServiceLocator()->get('Application\Database\TicketTable');
    }
}

