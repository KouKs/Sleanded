<?php

/**
 * Banner table gateway
 *
 * @author Mišel
 * 
    CREATE TABLE `messages` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(100) NULL COLLATE 'utf8_bin',
        `email` VARCHAR(100) NULL COLLATE 'utf8_bin',
        `text` TEXT(3000) NULL COLLATE 'utf8_bin',
        `viewed` TINYINT(4) NOT NULL DEFAULT '0',
        `sent` INT NULL,
        `ip` VARCHAR(25) NULL COLLATE 'utf8_bin',
        PRIMARY KEY (`id`)
    )
    COMMENT='Sleanded contact form messages'
    COLLATE='utf8_bin'
    ENGINE=MyISAM
    ;

 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class MessageTable {
    
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
    
    public function add( ContactFilter $contact ) {
        
        $data = [
            'name'      => $contact->name,
            'email'     => $contact->email,
            'text'      => $contact->text,
            'sent'      => time(),
            'ip'        => $_SERVER['REMOTE_ADDR'],
        ];
        
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "An error occured, please conntact administrator." );
    }
    
    public function edit( $id , $data )
    {
        
        if( !$this->tableGateway->update( $data , [ 'id' => $id ] ) )
            throw new \Exception( "An error occured, please conntact administrator." );
    }
    
    public function delete( $id )
    {
        if( !$this->tableGateway->delete( [ 'id' => $id ] ) )
            // TODO: TRANSLATION
            throw new \Exception( "An error occured, please conntact administrator." );
    }
    
    public function select( $where = null , $join = null , $cond = null , $cols = null , $order = "id ASC" )
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->where( $where )
                ->order( $order );
        
        if( $join != null ) $select->join( $join , $cond , $cols );
        
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
}