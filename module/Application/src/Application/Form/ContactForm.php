<?php
/**
 * Contact Form
 *
 * @author Pavel
 */
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


class ContactForm extends Form
{
    public function __construct()
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
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'e-mail'
            ),
        ));
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
    }
    
    public function getInputFilter( )
    {
        
        $inputFilter = new InputFilter();

        $inputFilter->add(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 3,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'email',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 3,
                         'max'      => 100,
                     ),
                ),
                array(
                    'name'    => 'EmailAddress',
                    'options' =>array(
                        'domain'   => 'true',
                        'hostname' => 'true',
                        'mx'       => 'true',
                        'deep'     => 'true',
                        'message'  => 'Invalid email address',
                    ),
                )
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'text',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 10,
                        'max'      => 3000,
                    ),
                ),
            ),
        ));

        return $inputFilter;
    }
    
}