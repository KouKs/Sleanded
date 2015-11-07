<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Application\Model\MessageTable;
use Application\Model\ReferenceTable;
use Application\Model\PostTable;

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
                'Application\Model\MessageTable' =>  function($sm) {
                    $tableGateway = $sm->get('MessageTableGateway');
                    $table = new MessageTable( $tableGateway );
                    return $table;
                },
                'MessageTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway( 'messages' , $dbAdapter , null , new ResultSet() );
                },
                'Application\Model\ReferenceTable' =>  function($sm) {
                    $tableGateway = $sm->get('ReferenceTableGateway');
                    $table = new ReferenceTable( $tableGateway );
                    return $table;
                },
                'ReferenceTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway( 'reference' , $dbAdapter , null , new ResultSet() );
                },
                'Application\Model\PostTable' =>  function($sm) {
                    $tableGateway = $sm->get('PostTableGateway');
                    $table = new PostTable( $tableGateway );
                    return $table;
                },
                'PostTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway( 'posts' , $dbAdapter , null , new ResultSet() );
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
