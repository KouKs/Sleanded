<?php
/**
 * Contact Form
 *
 * @author Mišel
 */
namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null,$kategorie = null)
    {
        parent::__construct('login');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                // TODO: TRANSLATION
                'placeholder' => 'Nick or e-mail'
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                // TODO: TRANSLATION
                'placeholder' => 'Password'
            ),
        ));
        $this->add(array(
            'name' => 'remember',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'checked_value' => 'true',
                'unchecked_value' => 'false'
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