<?php

namespace Application\Database\TableModel;

class Project
{
    public $name, $desc, $progressPoints, $progress, $time, $deadline;

    public function exchangeArray( $data )
    {
        $this->name             = ( isset($data['name']) ) ? $data['name'] : null;
        $this->desc             = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->progressPoints   = ( isset($data['progressPoints']) ) ?  $data['progressPoints'] : null;
        $this->progress         = ( isset($data['progress']) ) ? $data['progress'] : null;
        $this->time             = ( isset($data['time']) ) ? $data['time'] : null;
        $this->deadline         = ( isset($data['deadline']) ) ? $data['deadline'] : null;
    }
}