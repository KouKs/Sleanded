<?php
/**
 * NewUser Form
 *
 * @author Mišel
 */
namespace Admin\Form;

use Zend\Form\Form;

class NewUserForm extends Form
{
    public function __construct($name = null,$kategorie = null)
    {
        parent::__construct('new_user');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'nick'
            ),
        ));
        $this->add(array(
            'name' => 'full_name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'full name'
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'e-mail'
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'placeholder' => 'password'
            ),
        ));
        $this->add(array(
            'name' => 'job',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => ''
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
}