<?php

namespace Application\Database\TableModel;

class Reference
{
    public $name, $desc, $text, $img;

    public function exchangeArray($data)
    {
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->text  = ( isset($data['text']) ) ? $data['text']  : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
    }
}