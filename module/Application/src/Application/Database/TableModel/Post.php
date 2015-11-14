<?php

namespace Application\Database\TableModel;

class Post
{
    public $topic, $author_id, $text, $img;

    public function exchangeArray($data)
    {
        $this->topic = ( isset($data['topic']) ) ? $data['topic'] : null;
        $this->desc = ( isset($data['desc']) ) ? $data['desc'] : null;
        $this->author_id = ( isset($data['author_id']) ) ? $data['author_id'] : null;
        $this->text  = ( isset($data['text']) ) ? $data['text']  : null;
        $this->img  = ( isset($data['img']) ) ? $data['img']  : null;
    }
}