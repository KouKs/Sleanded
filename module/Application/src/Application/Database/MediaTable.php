<?php

/* 
CREATE TABLE `media` (
	`id` INT NULL AUTO_INCREMENT,
	`url` VARCHAR(50) NOT NULL,
	INDEX `id` (`id`)
)
COLLATE='utf8_bin'
ENGINE=MyISAM
;


 */
namespace Application\Database;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class MediaTable {
    
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
    
    public function add( TableModel\Media $m ) {
        
        $data = [
            'name' => $m->name,
            'url' => $m->url,
        ];
        
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "An error occured, please contact administrator." );
    }
    
    public function edit( $id , $data )
    {
        if( $id == "*" )
        {
            $this->tableGateway->update( $data );
        }
        else
        {
            $this->tableGateway->update( $data , [ 'id' => $id ] );
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
                ->order($order);
        
        if( $limit ) $select->limit( $limit );
        if( $where ) $select->where( $where );
        if( $join != null ) $select->join( $join , $cond , $cols );
        
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
}

