<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ProfileEditForm;
use Admin\Model\ProfileEditFilter;
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
        $form = new ProfileEditForm( $user[0]["desc"] , $user[0]["displayed"] );
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $post = $request->getPost()->toArray();
            $files = $request->getFiles( );
            $post['img'] = "uploads/" . $files["img"]["name"];

            $profileEdit = new ProfileEditFilter();
            $form->setInputFilter( $profileEdit->getInputFilter() );
            $form->setData( $post );

            if ( $form->isValid() )
            {
                $filter = new \Zend\Filter\File\RenameUpload("./public/uploads/");
                $filter->setUseUploadName(true);
                $filter->filter( $files['img'] );
                
                $profileEdit->exchangeArray( $form->getData() );
                $this->getUserTable()->edit( $this->user->id , $profileEdit->toArray() );
                
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
            'user'          => $user,
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
        return $this->getServiceLocator()->get('Admin\Model\UserTable');
    }
}

