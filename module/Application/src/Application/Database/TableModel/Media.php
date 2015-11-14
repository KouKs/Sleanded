<?php

namespace Application\Database\TableModel;

class Media
{
    public $url;

    public function exchangeArray( $data )
    {
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->url = ( isset($data['url']) ) ? $data['url'] : null;
    }
}