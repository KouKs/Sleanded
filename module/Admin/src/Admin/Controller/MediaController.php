<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Application\Database\TableModel\Media;

use Admin\Form\MediaForm;

class MediaController extends AbstractActionController
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
        $request = $this->getRequest();
        
        if( $request->isPost() )
        {            
            $file = $request->getFiles( )->toArray();
            

            $filter = new \Zend\Filter\File\RenameUpload([
                'target' => APP_DIR . '/../public/uploads/img.png',
                'randomize' => true,
            ]);
            $name = $filter->filter( $file["file"] );

            $post['name'] = $file["file"]["name"];
            $post['url'] = "uploads/" . explode( '\\' , $name["tmp_name"] )[1];
            
            $m = new Media();
            $m->exchangeArray( $post );
            $this->getMediaTable()->add( $m );


        }
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'form'          => new MediaForm(),
            'images'        => $this->getMediaTable()->select(null,null,null,null,null,"ID desc"),
        ];
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        
        $mediaTable = $this->getMediaTable();
        $url = $this->getMediaTable()->select("id=".$id)->toArray()[0]["url"];
        
        $mediaTable->delete( $id );
        
        \unlink( realpath( APP_DIR . '/../public/' . $url ) );
        
        return $this->response;
    }

    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Model\Media 
     */
    private function getMediaTable()
    {
        return $this->getServiceLocator()->get('Application\Database\MediaTable');
    }
}

