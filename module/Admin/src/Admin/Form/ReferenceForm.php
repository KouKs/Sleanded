<?php
/**
 * Reference Form
 *
 * @author Kouks
 */
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ReferenceForm extends Form
{
    public function __construct()
    {
        parent::__construct('reference');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Project name'
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Brief description',
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
            'name' => 'img',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'img',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
    
    public function addInputFilter()
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
                        'max'      => 20,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'desc',
            'required' => true,
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
            'name'     => 'text',
            'required' => true,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 3,
                         'max'      => 10000,
                     ),
                ),
            ),
        ));

        $this->setInputFilter( $inputFilter );
    }
}