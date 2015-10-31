<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\LoginForm;
use Admin\Model\LoginFilter;

use Application\Helper\Messenger;

class LoginController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout( "layout/empty" );
        $logged = new Container('user');
        $table = $this->getUserTable();
        
        if( !$logged->boolLogged ) {
            $messenger = new Messenger;
            
            if( isset( $_COOKIE[ 'sleanded_admin' ] ) && $_COOKIE[ 'sleanded_admin' ] != '' ) {
                $credentials = explode( ";" , $_COOKIE[ 'sleanded_admin' ] );
                $user = $table->autologin( $credentials[ 0 ], $credentials[ 1 ] );
                if( count( $user ) == 1 ) {
                    $user = $user[0];
                    $this->registerSession($user, $logged);
                    return $this->redirect()->toRoute('admin', array(
                                        'controller' => 'index'
                    ));
                } else {
                    unset( $_COOKIE['sleanded_admin'] );
                    setcookie('sleanded_admin', '', time() - 3600);
                    $messenger(null, null, "Autologin failed. Please, login again!");
                }
            }
            
            $form = new LoginForm();
            $request = $this->getRequest();
            if( $request->isPost( ) )
            {
                $login = new LoginFilter( );
                $form->setInputFilter( $login->getInputFilter(  ) );
                $form->setData( $request->getPost( ) );
                if( $form->isValid( ) )
                {
                    $data = array( 
                        'name' => $form->getData()['name'],
                        'password' => $form->getData()['password'],
                        'remember' => $form->getData()['remember']
                    );
                    $login->exchangeArray( $data );
                    $user = $table->login( $login->name, $login->password );
                    if( count( $user ) == 1 ) {
                        $user = $user[0];
                        $this->registerSession($user, $logged);
                        if( $login->remember == 1 ) {
                            setcookie (
                                'sleanded_admin',
                                $user['name'].';'.$user['password'],
                                time() + ( 3600*24*15 )
                            );
                            $table->edit( $user['id'], [ 'ip' => $_SERVER['REMOTE_ADDR'], 'remember' => 1 ] );
                        }
                        return $this->redirect()->toRoute('admin', array(
                            'controller' => 'index'
                        ));
                    } else {
                        $messenger(null, null, "Invalid name/email or password. Please, try to log in again!");
                    }
                }
                else
                {
                    $messenger(null, "All form fields have to be filled!", null);
                }
            }
        } else {
            unset( $_COOKIE['sleanded_admin'] );
            setcookie('sleanded_admin', '', time() - 3600);
            $u = $table->select( [ 'name' => $logged->name ] )->toArray();
            $table->edit( $u[0]['id'], [ 'remember' => 0 ] );
            $logged->getManager()->getStorage()->clear('user');
            
            return $this->redirect()->toRoute('admin', array(
                                        'controller' => 'index'
            ));
            
        }
        
        return [
            'loginForm' => $form,
            
        ];
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of users table
     * @return Admin\Model\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Admin\Model\UserTable');
    }
    
    private function registerSession( $data, $container ) {
        $container->name = $data[ 'name' ];
        $container->boolLogged = true;
    }

}

