<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Application\Form\ContactForm;

class IndexController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        
        
        return [
            'contactForm' => new ContactForm(),
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
    

}

