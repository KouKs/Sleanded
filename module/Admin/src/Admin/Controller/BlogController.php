<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\PostForm;
use Admin\Model\PostFilter;
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
            $post = $request->getPost()->toArray();
            $files = $request->getFiles( );
            $post['img'] = "./uploads/" . $files["img"]["name"];

            $blogPost = new PostFilter();
            $form->setInputFilter( $blogPost->getInputFilter() );
            $form->setData( $post );

            if ( $form->isValid() )
            {
                $filter = new \Zend\Filter\File\RenameUpload("./public/uploads/");
                $filter->setUseUploadName(true);
                $filter->filter( $files['img'] );

                $blogPost->exchangeArray( $form->getData() );
                $this->getPostTable()->add( $blogPost );
                
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
        return $this->getServiceLocator()->get('Application\Model\PostTable');
    }
}

