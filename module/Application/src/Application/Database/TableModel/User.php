<?php

namespace Application\Database\TableModel;

class User
{
    public $name, $password, $remember, $full_name, $job, $email, $desc, $img, $displayed;
    public $data;

    public function exchangeArray($data)
    {
        $this->data = $data->toArray();
        
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->password  = ( isset($data['password']) ) ? hash( "sha256" , $data['password'] )  : null;
        $this->remember  = ( isset($data['remember']) ) ? $data['remember']  : null;
        $this->full_name = ( isset($data['full_name']) ) ? $data['full_name'] : null;
        $this->job = ( isset($data['job']) ) ? $data['job'] : null;
        $this->email = ( isset($data['email']) ) ? $data['email'] : null;
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
        $this->displayed  = ( isset($data['displayed']) ) ? $data['displayed']  : null;
    }
    
    public function toArray()
    {
        unset( $this->data["submit"] );
        return $this->data;
    }

}