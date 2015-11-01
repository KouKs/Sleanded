<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class Messenger extends AbstractHelper
{
    protected $html;

    const SUCCESS   = 'success';
    const NOTICE    = 'notice';
    const ERROR     = 'error';
    
    public function __invoke( $params )
    {
        list( $message , $type ) = $params;
        
        $this->html = "";
        
        if( isset( $message ) )
        {
            $this->html .= '<div class="shadow message ' . $type . '">';
                $this->html .= $message; 
            $this->html .= '</div>';
        }
        
        echo $this->html;
    }

}