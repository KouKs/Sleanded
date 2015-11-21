<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ProjectForm;

use Application\Helper\Messenger;
use Application\Database\TableModel\Project;

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
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'project'      => $this->getProjectTable()->select("id=". $id),
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

    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Database\ProjectTable 
     */
    private function getProjectTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ProjectTable');
    }
}

