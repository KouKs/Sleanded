<?php

/**
 * Banner table gateway
 *
 * @author Kouks
 * 
CREATE TABLE `reference` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL,
	`text` TEXT NULL,
	`img` VARCHAR(70) NULL,
	`time` DOUBLE UNSIGNED NULL,
	INDEX `id` (`id`),
	PRIMARY KEY (`id`)
)
COLLATE='utf8_bin'
ENGINE=MyISAM
;

 * 
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class ReferenceTable {
    
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
    
    public function add( ReferenceFilter $reference ) {
        
        $data = [
            'name'     => $reference->name,
            'text'     => $reference->email,
            'img'      => $reference->img,
            'time'     => time(),
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
    
    public function select( $where = null , $join = null , $cond = null , $cols = null , $order = "id ASC" )
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->where( $where )
                ->order( $order );
        
        if( $join != null ) $select->joinLeft( $join , $cond , $cols );
        
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
}