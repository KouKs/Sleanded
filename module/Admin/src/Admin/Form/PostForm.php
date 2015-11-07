<?php
/**
 * Reference Form
 *
 * @author Kouks
 */
namespace Admin\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct( $author_id )
    {
        parent::__construct('post');
        
        $this->add(array(
            'name' => 'topic',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Topic'
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Brief description'
            ),
        ));
        $this->add(array(
            'name' => 'text',
            'type' => 'textarea',
            'attributes' => array(
                'class' => 'editor'
            ),
        ));
        $this->add(array(
            'name' => 'author_id',
            'type' => 'hidden',
            'attributes' => array(
                'value' => $author_id,
            ),
        ));
        $this->add(array(
            'name' => 'img',
            'type' => 'Zend\Form\Element\File',
            'label' => 'Image displayed as miniature',
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
}