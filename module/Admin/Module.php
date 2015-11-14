<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Application\Database;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // SESSIONS
        $this->initSession(array(
            'remember_me_seconds' => 300,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));
        $eventManager->attach('dispatch', array($this, 'loadConfiguration' ));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
             'factories' => array(
                 'Application\Database\MessageTable' =>  function($sm) {
                     $tableGateway = $sm->get('MessageTableGateway');
                     $table = new Database\MessageTable($tableGateway);
                     return $table;
                 },
                 'MessageTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Database\TableModel\Message());
                     return new TableGateway('messages', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Database\MediaTable' =>  function($sm) {
                     $tableGateway = $sm->get('MediaTableGateway');
                     $table = new Database\MediaTable($tableGateway);
                     return $table;
                 },
                 'MediaTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Database\TableModel\Media());
                     return new TableGateway('media', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Database\PostTable' =>  function($sm) {
                     $tableGateway = $sm->get('PostTableGateway');
                     $table = new Database\PostTable($tableGateway);
                     return $table;
                 },
                 'PostTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Database\TableModel\Post());
                     return new TableGateway('posts', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Database\ReferenceTable' =>  function($sm) {
                     $tableGateway = $sm->get('ReferenceTableGateway');
                     $table = new Database\ReferenceTable($tableGateway);
                     return $table;
                 },
                 'ReferenceTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Database\TableModel\Reference());
                     return new TableGateway('reference', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Database\UserTable' =>  function($sm) {
                     $tableGateway = $sm->get('UserTableGateway');
                     $table = new Database\UserTable($tableGateway);
                     return $table;
                 },
                 'UserTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Database\TableModel\User());
                     return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
        );
    }
    
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
    
    public function loadConfiguration(MvcEvent $e)
    {           
        //$controller = $e->getTarget();
        //$controller->layout()->user = new Container('user');
    }
    
}
