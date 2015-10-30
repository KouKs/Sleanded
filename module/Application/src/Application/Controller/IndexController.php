<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;
use Application\Model\ContactFilter;

class IndexController extends AbstractActionController
{
    protected $tables = [ 'message' => false ];

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        $form = new ContactForm();
        $request = $this->getRequest();
        if ( $request->isPost() ) {
            $contact = new ContactFilter();
            $form->setInputFilter( $contact->getInputFilter() );
            $form->setData( $request->getPost() );

            if ( $form->isValid() ) {
                $contact->exchangeArray( $form->getData() );
                $this->getMessageTable()->add( $contact );
                // throw message
            }
        }
        
        return [
            'contactForm' => $form,
        ];
    }

    public function workAction()
    {
        $this->layout("layout/page");
        return [];
    }

    public function teamAction()
    {
        $this->layout("layout/page");
        return [];
    }
    
    public function contactAction()
    {
        $this->layout("layout/page");
        return [
            'contactForm' => new ContactForm(),
        ];
    }
    
    public function blogAction()
    {
        $this->layout("layout/page");
        return [];
    }
    

    public function getMessageTable()
    {
        if ( !$this->tables['message'] ) {
            $sm = $this->getServiceLocator();
            $this->tables['message'] = $sm->get('Application\Model\MessageTable');
        }
        return $this->tables['message'];
    }
}

