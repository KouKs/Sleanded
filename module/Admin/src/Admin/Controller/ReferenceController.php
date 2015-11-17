<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ReferenceForm;

use Application\Database\TableModel\Reference;
use Application\Helper\Messenger;

class ReferenceController extends AbstractActionController
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
            'reference' => $this->getReferenceTable()->fetchAll(),
        ];
    }

    public function addAction()
    {
        $this->layout("layout/admin");
        $form = new ReferenceForm();
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $r = new Reference();
                $r->exchangeArray( $request->getPost() );
                $this->getReferenceTable()->add( $r );
                
                $message = [ "Reference has been successfully added" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
            'images'        => $this->getMediaTable()->fetchAll()->toArray(),
        ];
    }
    
    public function editAction()
    {
        $this->layout("layout/admin");
        $id = $this->params('id');
        $form = new ReferenceForm();
        $request = $this->getRequest();
        $referenceTable = $this->getReferenceTable();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $r = new Reference();
                $r->exchangeArray( $request->getPost() );
                $referenceTable->edit( $id , $r->toArray() );
                
                $message = [ "Reference has been successfully edited" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        $form->setData( $referenceTable->select("id=".$id)->toArray()[0] );
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
            'images'        => $this->getMediaTable()->fetchAll()->toArray(),
        ];
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        
        $referenceTable = $this->getReferenceTable();
        $referenceTable->delete( $id );
        
        return $this->response;
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of reference table
     * @return Application\Database\ReferenceTable 
     */
    private function getReferenceTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ReferenceTable');
    }
    
    /**
     * Returns an isntance of message table
     * @return Application\Database\Media 
     */
    private function getMediaTable()
    {
        return $this->getServiceLocator()->get('Application\Database\MediaTable');
    }
}

