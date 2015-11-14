<?php

namespace Application\Database\TableModel;

class User
{
    public $name, $password, $remember;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->password  = ( isset($data['password']) ) ? $data['password']  : null;
        $this->remember  = ( isset($data['remember']) ) ? $data['remember']  : null;
        $this->full_name = ( isset($data['full_name']) ) ? $data['full_name'] : null;
        $this->job = ( isset($data['job']) ) ? $data['job'] : null;
        $this->email = ( isset($data['email']) ) ? $data['email'] : null;
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
        $this->displayed  = ( isset($data['displayed']) ) ? $data['displayed']  : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

}