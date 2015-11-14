<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Database\TableModel\Message;
use Application\Helper\Messenger;

class IndexController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        $form = new ContactForm();
        $request = $this->getRequest();
        
        
        if ( $request->isPost() )
        {
            $form->addInputFilter();
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $m = new Message();
                $m->exchangeArray( $request->getPost() );
                $this->getMessageTable()->add( $m );
                
                $message = [ "Your message has been successfully sent" , Messenger::SUCCESS ];
            }
            else
            {
                $message = [ "All inputs have to be filled out" , Messenger::ERROR ];
            }
        }
        
        return [
            'reference'     => $this->getReferenceTable()->select( null , 3 ),
            'posts'         => $this->getPostTable()->select( null, 
                                                              2,
                                                              "users",
                                                              "posts.author_id = users.id",
                                                              "full_name",
                                                              "posts.id DESC" ),
            'message'       => isset( $message ) ? $message : null,
            'contactForm'   => new ContactForm(),
        ];
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Model\MessageTable 
     */
    private function getMessageTable()
    {
        return $this->getServiceLocator()->get('Application\Database\MessageTable');
    }
    /**
     * Returns an isntance of reference table
     * @return Application\Model\ReferennceTable 
     */
    private function getReferenceTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ReferenceTable');
    }
    
    /**
     * Returns an isntance of post table
     * @return Application\Model\PostTable 
     */
    private function getPostTable()
    {
        return $this->getServiceLocator()->get('Application\Database\PostTable');
    }
}

