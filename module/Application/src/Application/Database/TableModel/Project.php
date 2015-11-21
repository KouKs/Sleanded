<?php

namespace Application\Database\TableModel;

class Project
{
    public $name, $desc, $progressPoints, $deadline;

    public function exchangeArray( $data )
    {
        $this->name             = ( isset($data['name']) ) ? $data['name'] : null;
        $this->desc             = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->progressPoints   = ( isset($data['progressPoints']) ) ?  $data['progressPoints'] : null;
        $this->deadline         = ( isset($data['deadline']) ) ? $data['deadline'] : null;
    }
}