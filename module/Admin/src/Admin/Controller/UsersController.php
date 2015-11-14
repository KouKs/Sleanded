<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\NewUserForm;

use Application\Database\TableModel\User;
use Application\Helper\Messenger;

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
        $request = $this->getRequest();
        $form = new NewUserForm();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $u = new User();
                $u->exchangeArray( $request->getPost() );
                $this->getUserTable()->add( $u );
                
                $message = [ "User has been successfully added" , Messenger::SUCCESS ];
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
        
        $userTable = $this->getUserTable();
        $userTable->delete( $id );
        
        return $this->response;
    }
    
    /**
     * Returns an isntance of users table
     * @return Admin\Model\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Database\UserTable');
    }
}