<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Model\ContactFilter;

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
            $contact = new ContactFilter();
            $form->setInputFilter( $contact->getInputFilter() );
            $form->setData( $request->getPost() );

            if ( $form->isValid() )
            {
                $contact->exchangeArray( $form->getData() );
                $this->getMessageTable()->add( $contact );
                // throw message
            }
        }
        
        return [
            'contactForm' => $form,
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

