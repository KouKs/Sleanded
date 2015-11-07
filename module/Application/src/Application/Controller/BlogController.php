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
                                                              "full_name",
                                                              "posts.id DESC" ),
            'message'       => isset( $message ) ? $message : null,
        ];
    }
    
    public function detailAction()
    {
        $this->layout("layout/page");
        $id = $this->params('id');
        
        return [
            'post'         => $this->getPostTable()->select( 'posts.id = ' . $id , 
                                                             null,
                                                             "users",
                                                             "posts.author_id = users.id",
                                                             "full_name",
                                                             "posts.id DESC" ),
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

