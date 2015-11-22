<?php

namespace Application\Database\TableModel;

class Ticket
{
    public $name, $desc, $importance, $author_id;
    public $data;
    
    public function exchangeArray($data)
    {
        $this->data = $data->toArray();
        
        $this->name = ( isset($data['name']) ) ? $data['name'] : null;
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->importance  = ( isset($data['importance']) ) ? $data['importance']  : null;
        $this->project_id  = ( isset($data['project_id']) ) ? $data['project_id']  : null;
        $this->author_id  = ( isset($data['author_id']) ) ? $data['author_id']  : null;
    }
    
    public function toArray()
    {
        unset( $this->data["submit"] );
        return $this->data;
    }
}