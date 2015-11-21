<?php

namespace Application\Database\TableModel;

class Project
{
    public $name, $desc, $progressPoints, $deadline;
    public $data;

    public function exchangeArray( $data )
    {
        $this->data = is_array( $data ) ? $data : $data->toArray();
        
        $this->name             = ( isset($data['name']) ) ? $data['name'] : null;
        $this->desc             = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->progressPoints   = ( isset($data['progressPoints']) ) ?  $data['progressPoints'] : null;
        $this->deadline         = ( isset($data['deadline']) ) ? $data['deadline'] : null;
    }
    
    public function toArray()
    {
        unset( $this->data["submit"] );
        
        if( is_int( $this->data["deadline"] ))
        {
            $deadlineUnix = $this->data["deadline"];
            $this->data["deadline"] = date( 'Y-m-d' , $deadlineUnix );
        }
        
        return $this->data;
    }
}