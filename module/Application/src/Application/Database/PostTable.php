<?php

/**
 * Blog post table gateway
 *
 * @author Kouks
 * 
 * 
CREATE TABLE `post` (
	`id` INT NULL AUTO_INCREMENT,
	`topic` VARCHAR(20) NULL DEFAULT NULL,
	`desc` VARCHAR(100) NULL DEFAULT NULL,
	`author_id` INT NULL,
	`text` TEXT NULL DEFAULT NULL,
	`img` VARCHAR(100) NULL DEFAULT NULL,
	`time` DOUBLE UNSIGNED NULL DEFAULT NULL,
	`ip` VARCHAR(100) NULL DEFAULT NULL,
	INDEX `id` (`id`)
)
COLLATE='utf8_bin'
ENGINE=MyISAM
;

 */
namespace Application\Database;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Admin\Model\PostFilter;

class PostTable {
    
    protected $tableGateway;

    public function __construct( TableGateway $tableGateway )
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()->select();
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
    
    public function add( TableModel\Post $post ) {
        
        $data = [
            'topic'      => $post->topic,
            'desc'      => $post->desc,
            'author_id'     => $post->author_id,
            'text'      => $post->text,
            'img'      => $post->img,
            'time'      => time(),
            'ip'        => $_SERVER['REMOTE_ADDR'],
        ];
        
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "An error occured, please contact administrator." );
    }
    
    public function edit( $id , $data )
    {
        if( $id == "*" )
        {
            $this->tableGateway->update( $data );
                //throw new \Exception( "An error occured, please contact administrator." );
        }
        else
        {
            $this->tableGateway->update( $data , [ 'id' => $id ] );
                //throw new \Exception( "An error occured, please contact administrator." );
        }
    }
    
    public function delete( $id )
    {
        if( !$this->tableGateway->delete( [ 'id' => $id ] ) )
            throw new \Exception( "An error occured, please contact administrator." );
    }
    
    public function select( $where = null , $limit = null , $join = null , $cond = null , $cols = null , $order = "id DESC" )
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->order( $order );
        
        if( $limit ) $select->limit( $limit );
        if( $where ) $select->where( $where );
        if( $join != null ) $select->join( $join , $cond , $cols );
        
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
    
}