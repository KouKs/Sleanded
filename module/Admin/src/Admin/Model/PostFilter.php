<?php

namespace Admin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PostFilter implements InputFilterAwareInterface
{
    public $topic, $author_id, $text, $img;

    public function exchangeArray($data)
    {
        $this->topic = ( isset($data['topic']) ) ? $data['topic'] : null;
        $this->author_id = ( isset($data['author_id']) ) ? $data['author_id'] : null;
        $this->text  = ( isset($data['text']) ) ? $data['text']  : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
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
                        'max'      => 100,
                    ),
                ),
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
                         'min'      => 3,
                         'max'      => 10000,
                     ),
                ),
            ),
        ));

        return $inputFilter;
    }
}