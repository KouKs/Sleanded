<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

use Admin\Form\LoginForm;

use Application\Database\TableModel\User;
use Application\Helper\Messenger;

class LoginController extends AbstractActionController
{
    protected $logged;
    
    public function indexAction()
    {
        $this->layout( "layout/empty" );
        $this->logged = new Container('user');
        $table = $this->getUserTable();
        $form = new LoginForm();
        
        if( !$this->logged->boolLogged )
        {
            $messenger = new Messenger;
            
            if( isset( $_COOKIE[ 'sleanded_admin' ] ) && $_COOKIE[ 'sleanded_admin' ] != '' )
            {
                $credentials = explode( ";" , $_COOKIE[ 'sleanded_admin' ] );
                $user = $table->autologin( $credentials[ 0 ], $credentials[ 1 ] );
                
                if( count( $user ) == 1 )
                {
                    $user = $user[0];
                    $this->registerSession($user, $this->logged);
                    return $this->redirect()->toRoute('admin', array(
                                        'controller' => 'index'
                    ));
                }
                else
                {
                    unset( $_COOKIE['sleanded_admin'] );
                    setcookie('sleanded_admin', '', time() - 3600);
                    $message = [ "Autologin failed, please log in" , Messenger::ERROR ];
                }
            }
            
            $request = $this->getRequest();
            if( $request->isPost( ) )
            {
                $form->addInputFilter();
                $form->setData( $request->getPost( ) );
                if( $form->isValid( ) )
                {
                    $u = new User( );
                    $u->exchangeArray( $request->getPost( ) );
                    $user = $table->login( $u->name, $u->password );
                    
                    if( count( $user ) == 1 )
                    {
                        $user = $user[0];
                        $this->registerSession($user, $this->logged);
                        if( $u->remember == 1 )
                        {
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
                    }
                    else
                    {
                        $message = [ "Invalid name/email or password. Please, try to log in again!" , Messenger::ERROR ];
                    }
                }
                else
                {
                    $message = [ "All form fields have to be filled!" , Messenger::NOTICE ];
                }
            }
        }
        else
        {
            $this->logout( );            
        }
        
        return [
            'message'       => isset( $message ) ? $message : null,
            'loginForm'     => $form,
        ];
    }
    
    /*************************************************************************\
     | Private functions                                                          |
    \*************************************************************************/
    
    /**
     * Returns an isntance of users table
     * @return Admin\Database\UserTable 
     */
    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Database\UserTable');
    }
    
    private function registerSession( $data, $container ) {
        $container->name = $data[ 'name' ];
        $container->id = $data[ 'id' ];
        $container->fullName = $data[ 'full_name' ];
        $container->boolLogged = true;
    }
    
    /**
     * Logout function
     * @return void
     */
    private function logout( )
    { 
        /*
         * cleaning cookies
         */
        unset( $_COOKIE['sleanded_admin'] );
        setcookie('sleanded_admin', '', time() - 3600);
        
        /*
         * turning off remember in db
         */
        $table = $this->getUserTable();
        $u = $table->select( [ 'name' => $this->logged->name ] )->toArray();
        $table->edit( $u[0]['id'], [ 'remember' => 0 ] );
        
        /*
         * cleaning session
         */
        $this->logged->getManager()->getStorage()->clear('user');

        /*
         * redirect
         */
        return $this->redirect()->toRoute('admin', array(
            'controller' => 'index'
        ));
    }
}

