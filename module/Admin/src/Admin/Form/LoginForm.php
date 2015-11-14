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
    public function __construct()
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
    
    public function getInputFilter()
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
                        'max'      => 30,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'password',
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

        return $inputFilter;
    }
}