<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ProjectController extends AbstractActionController
{

    public function progressAction()
    {
        $this->layout("layout/progress");
        $id = $this->params('id');
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'project'       => $this->getProjectTable()->select('id='.$id),
        ];
    }


    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of message table
     * @return Application\Database\ProjectTable 
     */
    private function getProjectTable()
    {
        return $this->getServiceLocator()->get('Application\Database\ProjectTable');
    }
}

