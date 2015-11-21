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
    
    public function deleteAction()
    {
        $id = $this->params('id');
        
        $projectTable = $this->getProjectTable();
        $projectTable->delete( $id );
        
        return $this->response;
    }

    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Database\MessageTable 
     */
    private function getProjectTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ProjectTable');
    }
}

