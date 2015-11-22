<?php
/**
 * Ticket table gateway
 *
 * @author Kouks
 * 
 CREATE TABLE `tickets` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`desc` TEXT NULL,
	`time` BIGINT UNSIGNED NOT NULL,
	`importance` TINYINT UNSIGNED NOT NULL DEFAULT '1',
        `project_id` INT UNSIGNED NOT NULL,
	`author_id` MEDIUMINT UNSIGNED NOT NULL,
	`assigned_to` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0',
	`resolved` TINYINT UNSIGNED NOT NULL DEFAULT '0',
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

class TicketTable {
    
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
    
    public function add( TableModel\Ticket $t ) {
        
        $data = [
            'name'          => $t->name,
            'desc'          => $t->desc,
            'importance'    => $t->importance,
            'project_id'    => $t->project_id,
            'author_id'     => $t->author_id,
            'time'          => time(),
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
        if( $join ) $select->join( $join , $cond , $cols , "left" );
        
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
    
}