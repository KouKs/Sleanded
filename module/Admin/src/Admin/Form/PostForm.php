<?php
/**
 * Reference Form
 *
 * @author Kouks
 */
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PostForm extends Form
{
    public function __construct( $author_id )
    {
        parent::__construct('post');
        
        $this->add(array(
            'name' => 'topic',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Topic'
            ),
        ));
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                'placeholder' => 'Brief description'
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
            'name' => 'author_id',
            'type' => 'hidden',
            'attributes' => array(
                'value' => $author_id,
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
            'name'     => 'topic',
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
            'name'     => 'text',
            'required' => true,
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