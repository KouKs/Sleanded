<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class Date extends AbstractHelper
{
    protected $time;
    
    public function __invoke( $time , $type = 'days' )
    {
        $this->time = $time;
        switch( $type )
        {
            case 'days':
                return @date( 'j. n. Y' , $this->time );
            case 'minutes':
                return @date( 'j. n. Y, G:i' , $this->time );
        }
    }
    
    /*
    public function basic( )
    {
        return date( 'j. N. Y' , $this->time );
    }
     */
}
