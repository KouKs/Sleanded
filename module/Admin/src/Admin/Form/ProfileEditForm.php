<?php
/**
 * Profile edit form
 *
 * @author kouks
 */
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ProfileEditForm extends Form
{
    public function __construct( )
    {
        parent::__construct('profile-edit');

        $this->add(array(
            'name' => 'full_name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Your full name',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'E-mail',
            ),
        ));
        $this->add(array(
            'name' => 'job',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Your position in company',
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Something about yourself',
            ),
        ));
        $this->add(array(
            'name' => 'img',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'img',
            ),
        ));
        $this->add(array(
            'name' => 'displayed',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'checked_value' => 1,
                'unchecked_value' => 0,
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
    
    public function addInputFilter() {
        $inputFilter = new InputFilter();
        
        $inputFilter->add(array(
            'name'     => 'full_name',
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
                        'min'      => 2,
                        'max'      => 30,
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name'     => 'job',
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
                        'min'      => 1,
                        'max'      => 25,
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
            'name'     => 'desc',
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
                        'min'      => 20,
                        'max'      => 300,
                    ),
                ),
            ),
        ));
        
        $this->setInputFilter( $inputFilter );
    }
}