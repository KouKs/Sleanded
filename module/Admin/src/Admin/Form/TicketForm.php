<?php
/**
 * Reference Form
 *
 * @author Kouks
 */
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class TicketForm extends Form
{
    public function __construct( $author , $project )
    {
        parent::__construct('reference');
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Ticket name'
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Brief description (optional)',
            ),
        ));
        $select = new \Zend\Form\Element\Select('importance');
        $select->setLabel('Set importance of this ticket');
        $select->setValueOptions(array(
                '1' => 'Very low',
                '2' => 'Low',
                '3' => 'Medium',
                '4' => 'High',
                '5' => 'Very high',
        ));
        $this->add($select);
        
        $this->add(array(
            'name' => 'author_id',
            'type' => 'hidden',
            'attributes' => array(
                'value' => $author
             ),
        ));
        $this->add(array(
            'name' => 'project_id',
            'type' => 'hidden',
            'attributes' => array(
                'value' => $project
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
            'required' => false,
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