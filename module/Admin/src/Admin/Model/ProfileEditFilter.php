<?php

namespace Admin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ProfileEditFilter implements InputFilterAwareInterface
{
    public $desc, $img, $displayed;
    
    public function exchangeArray($data)
    {
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
        $this->displayed  = ( isset($data['displayed']) ) ? $data['displayed']  : null;
    }
    public function toArray()
    {
        if( isset( $this->desc ) ) $data["desc"] = $this->desc;
        if( $this->img !== "uploads/" ) $data["img"] = $this->img;
        if( isset( $this->displayed ) ) $data["displayed"] = $this->displayed;
        return $data;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

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
                        'max'      => 1000,
                    ),
                ),
            ),
        ));

        return $inputFilter;
    }
}