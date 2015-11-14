<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class UrlParser extends AbstractHelper
{
    public function __invoke( $str )
    {
        $str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $str = @str_replace( " " , "-" , $str );
        $str = strtolower( $str );
        
        return $str;
    }
}
