<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'view_helpers' => array(
        'factories' => array(
            'urlparser' => function($sm) {
                $helper = new Application\Helper\UrlParser();
                return $helper;           
            },
            'date' => function($sm) {
                $helper = new Application\Helper\Date();
                return $helper;           
            },
            'messenger' => function($sm) {
                $helper = new Application\Helper\Messenger();
                return $helper;           
            },
            'media' => function($sm) {
                $helper = new Application\Helper\Media();
                return $helper;           
            },
        ),
        'invokables' => array(
            //'menu' => 'Application\Helper\Menu', 
            'messenger' => 'Application\Helper\Messenger', 
        ),  
    ),
              
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin[/[:controller[/[:action[/[:id[/[:seo]]]]]]]]',
                    'constraints' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[0-9]+',
                        'seo'        => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'        => 'Admin\Controller\IndexController',
            'Admin\Controller\Messages'     => 'Admin\Controller\MessagesController',
            'Admin\Controller\Login'        => 'Admin\Controller\LoginController',
            'Admin\Controller\Users'        => 'Admin\Controller\UsersController',
            'Admin\Controller\Reference'    => 'Admin\Controller\ReferenceController',
            'Admin\Controller\Blog'         => 'Admin\Controller\BlogController',
            'Admin\Controller\Profile'      => 'Admin\Controller\ProfileController',
            'Admin\Controller\Media'        => 'Admin\Controller\MediaController',
            'Admin\Controller\Projects'     => 'Admin\Controller\ProjectsController',
        ),
    ), 
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'admin/index/index'       => __DIR__ . '/../view/admin/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
             
);