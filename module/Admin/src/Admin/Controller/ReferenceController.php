<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\ReferenceForm;
use Admin\Model\ReferenceFilter;
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
        $refereceTable = $this->getReferenceTable();
        
        
        return [
            'reference' => $refereceTable->fetchAll(),
        ];
    }

    public function addAction()
    {
        $this->layout("layout/admin");
        $form = new ReferenceForm();
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $post = $request->getPost()->toArray();
            $files = $request->getFiles( );
            $post['img'] = "./uploads/" . $files["img"]["name"];

            $reference = new ReferenceFilter();
            $form->setInputFilter( $reference->getInputFilter() );
            $form->setData( $post );

            if ( $form->isValid() )
            {
                $filter = new \Zend\Filter\File\RenameUpload("./public/uploads/");
                $filter->setUseUploadName(true);
                $filter->filter( $files['img'] );

                $reference->exchangeArray( $form->getData() );
                $this->getReferenceTable()->add( $reference );
                
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
     * @return Application\Model\ReferenceTable 
     */
    private function getReferenceTable()
    {
        return $this->getServiceLocator()->get('Application\Model\ReferenceTable');
    }
}

