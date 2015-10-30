<?php
/**
 * Contact Form
 *
 * @author Pavel
 */
namespace Application\Form;

use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null,$kategorie = null)
    {
        parent::__construct('contact');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'name'
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'placeholder' => 'e-mail'
            ),
        ));
        /*$this->add(array(
            'name' => 'kategorie',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'empty_option' => array(
                    'label' => 'where did you hear of us',
                    'attributes' => array(
                        'selected' => 'selected',
                        'disabled' => 'disabled',
                        'hdidden' => 'hidden',
                    ),
                ),
                'value_options' => array(
                    'facebook' => array(
                        'label' => "Facebook",
                        'value' => "Facebook",
                    ),
                    'twitter' => array(
                        'label' => "Twitter",
                        'value' => "Twitter",
                    ),
                ),
            ),
        ));*/
        $this->add(array(
            'name' => 'text',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'your message'
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
        /*
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Přidat',
                'class' => 'btn btn-info',
                'id' => 'cat',
                'style' => 'display: none;'
            ),
        ));
         */
    }
}