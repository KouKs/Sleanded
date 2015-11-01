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
        ];
    }


}

