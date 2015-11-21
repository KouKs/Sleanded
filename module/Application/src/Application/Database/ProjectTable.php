<?php

/**
 * Banner table gateway
 *
 * @author Kouks
 * 
CREATE TABLE `projects` (
	`id` INT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`desc` TEXT NULL,
	`progressPoints` VARCHAR(150) NULL,
	`progress` INT NULL DEFAULT '0',
	`time` BIGINT UNSIGNED NOT NULL,
	`deadline` BIGINT UNSIGNED NOT NULL,
	INDEX `id` (`id`)
)
COLLATE='utf8_bin'
ENGINE=MyISAM
;


 * 
 */
namespace Application\Database;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class ProjectTable {
    
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
    
    public function add( TableModel\Project $p ) {
        
        if( empty( $p->progressPoints[ count( $p->progressPoints ) - 1 ] ) )
            unset( $p->progressPoints[ count( $p->progressPoints ) - 1 ] );
            
        $data = [
            'name' => $p->name,
            'desc' => $p->desc,
            'progressPoints' => implode( "|" , $p->progressPoints ),
            'progress' => $p->progress,
            'time' => time(),
            'deadline' => strtotime( $p->deadline ),
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