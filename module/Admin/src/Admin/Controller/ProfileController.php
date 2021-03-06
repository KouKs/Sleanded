<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ProfileEditForm;

use Application\Database\TableModel\User;
use Application\Helper\Messenger;

class ProfileController extends AbstractActionController
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
        $user = $this->getUserTable()->select("id = ". $this->user->id)->toArray(); 
        $form = new ProfileEditForm( );
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $u = new User;  
                $u->exchangeArray( $request->getPost() );
                $this->getUserTable()->edit( $this->user->id , $u->toArray() );
                
                $message = [ "Profile has been successfully edited" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        $form->setData( $user[0] );
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
            'user'          => $user,
            'images'        => $this->getMediaTable()->fetchAll(),
        ];
    }


    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of user table
     * @return Admin\Model\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Database\UserTable');
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

