<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Model\ContactFilter;
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
            $messenger = new Messenger;
            $contact = new ContactFilter();
            $form->setInputFilter( $contact->getInputFilter() );
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $contact->exchangeArray( $form->getData() );
                $this->getMessageTable()->add( $contact );
                // TODO: TRANSLATION
                $messenger("You message has been successfully sent!", null, null);
            } else {
                // TODO: TRANSLATION
                $messenger(null, null, "All form fields have to be filled!");
            }
        }
        
        return [
            'contactForm' => new ContactForm(),
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

