<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Database\TableModel\Message;
use Application\Helper\Messenger;

class ContactController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout("layout/page");
        
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
}

