<?php
/**
 * Reference Form
 *
 * @author Kouks
 */
namespace Admin\Form;

use Zend\Form\Form;

class ReferenceForm extends Form
{
    public function __construct($name = null,$kategorie = null)
    {
        parent::__construct('new_user');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'name'
            ),
        ));
        $this->add(array(
            'name' => 'text',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'description'
            ),
        ));
        $this->add(array(
            'name' => 'img',
            'type' => 'Zend\Form\Element\File',
            'label' => 'Image displayed in miniature',
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
}