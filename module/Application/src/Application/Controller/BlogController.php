<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class BlogController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout("layout/page");
        return [
            'posts'         => $this->getPostTable()->select( null, 
                                                              null,
                                                              "users",
                                                              "posts.author_id = users.id",
                                                              array( "id" , "full_name" ),
                                                              "posts.id DESC" ),
            'message'       => isset( $message ) ? $message : null,
        ];
    }

    /**
     * Returns an isntance of post table
     * @return Application\Model\PostTable 
     */
    private function getPostTable()
    {
        return $this->getServiceLocator()->get('Application\Model\PostTable');
    }

}

