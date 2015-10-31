<?php

/* 
    CREATE TABLE `users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8_bin',
        `full_name` VARCHAR(50) NULL DEFAULT '0' COLLATE 'utf8_bin',
        `job` VARCHAR(50) NULL DEFAULT '0' COLLATE 'utf8_bin',
        `email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
        `password` VARCHAR(80) NULL DEFAULT NULL COLLATE 'utf8_bin',
        `remember` TINYINT(4) NULL DEFAULT '0',
        `ip` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8_bin',
        PRIMARY KEY (`id`)
    )
    COMMENT='Users table'
    COLLATE='utf8_bin'
    ENGINE=MyISAM
    AUTO_INCREMENT=2
;

 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class UserTable {
    
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
            'password'  => sha1( $contact->password ),
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
    
    public function autologin ( $nick, $password_hash ) {
        $select = $this->tableGateway->getSql()
                ->select()
                ->where( [  'name' => $nick, 'password' => $password_hash,
                            'ip' => $_SERVER['REMOTE_ADDR'], 'remember' => 1 ] )
                ->limit( 1 );
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs->toArray();
    }
    
    public function login ( $name, $password ) {
        $where = new \Zend\Db\Sql\Where();
        $where  ->nest()
                ->equalTo( 'name', $name)
                ->or
                ->equalTo( 'email', $name)
                ->unnest()
                ->and
                ->equalTo( 'password', hash( 'sha256',  $password ) );
        
        $select = $this->tableGateway->getSql()
                ->select()
                ->where( $where )
                ->limit( 1 );
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs->toArray();        
    }
}

