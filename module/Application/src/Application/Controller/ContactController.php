<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Model\ContactFilter;
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
            $messenger = new Messenger;
            $contact = new ContactFilter();
            $form->setInputFilter( $contact->getInputFilter() );
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $contact->exchangeArray( $form->getData() );
                $this->getMessageTable()->add( $contact );
                
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
        return $this->getServiceLocator()->get('Application\Model\MessageTable');
    }
}

