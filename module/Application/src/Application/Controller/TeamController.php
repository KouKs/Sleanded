<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TeamController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout("layout/page");
        return [
            'message'       => isset( $message ) ? $message : null,
            'team'          => $this->getUserTable()->select("displayed=1"),
        ];
    }


    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of user table
     * @return Admin\Model\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Database\UserTable');
    }
}

