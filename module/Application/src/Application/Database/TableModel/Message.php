<?php

namespace Application\Database\TableModel;

class Message
{
    public $name, $email, $text;

    public function exchangeArray($data)
    {
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->email  = ( isset($data['email']) ) ? $data['email']  : null;
        $this->text  = ( isset($data['text']) ) ? $data['text']  : null;
    }

}