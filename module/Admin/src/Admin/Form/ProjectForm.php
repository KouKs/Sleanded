<?php
/**
 * Contact Form
 *
 * @author kouks
 */
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ProjectForm extends Form
{
    public function __construct()
    {
        parent::__construct('project');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Name of project'
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Description of project',
            ),
        ));
        
        $this->add(array(
            'name' => 'progressPoints',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Points of progress',
            ),
        ));

        $this->add(array(
            'name' => 'deadline',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Deadline'
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
                        'max'      => 30,
                    ),
                ),
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
                         'min'      => 3,
                         'max'      => 1500,
                     ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name'     => 'progressPoints',
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
                         'max'      => 200,
                     ),
                ),
            ),
        ));
        $this->setInputFilter( $inputFilter );
    }
}