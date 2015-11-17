<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\PostForm;

use Application\Database\TableModel\Post;
use Application\Helper\Messenger;

class BlogController extends AbstractActionController
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
        $postTable = $this->getPostTable();

        return [
            'posts' => $postTable->select(  null, 
                                            null,
                                            "users",
                                            "posts.author_id = users.id",
                                            "full_name",
                                            "posts.id DESC" ),
        ];
    }

    public function addAction()
    {
        $this->layout("layout/admin");
        $form = new PostForm( $this->user->id );
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $p = new Post();
                $p->exchangeArray( $request->getPost() );
                $this->getPostTable()->add( $p );
                
                $message = [ "Post has been successfully added" , Messenger::SUCCESS ];
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
        $form = new PostForm( $this->user->id );
        $request = $this->getRequest();
        $postTable = $this->getPostTable();
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $p = new Post();
                $p->exchangeArray( $request->getPost() );
                $postTable->edit( $id , $p->toArray() );
                
                $message = [ "Post has been successfully edited" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        $form->setData( $postTable->select("id=".$id)->toArray()[0] );
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => $form,
            'images'        => $this->getMediaTable()->fetchAll()->toArray(),
        ];
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
        
        $postTable = $this->getPostTable();
        $postTable->delete( $id );
        
        return $this->response;
    }

    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of post table
     * @return Application\Model\PostTable 
     */
    private function getPostTable()
    {
        return $this->getServiceLocator()->get('Application\Database\PostTable');
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

