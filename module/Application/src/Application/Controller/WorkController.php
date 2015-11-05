<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class WorkController extends AbstractActionController
{
    
    public function indexAction()
    {
        $this->layout("layout/page");
        
        return [
            'reference'     => $this->getReferenceTable()->select(),
            'message'       => isset( $message ) ? $message : null,
        ];
    }


    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of reference table
     * @return Application\Model\ReferennceTable 
     */
    private function getReferenceTable()
    {
        return $this->getServiceLocator()->get('Application\Model\ReferenceTable');
    }
}

