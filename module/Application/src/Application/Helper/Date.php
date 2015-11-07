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
    
    public function __invoke( $time )
    {
        $this->time = $time;
        return @date( 'j. N. Y' , $this->time );
    }
    
    /*
    public function basic( )
    {
        return date( 'j. N. Y' , $this->time );
    }
     */
}
