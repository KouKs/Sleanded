<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class Media extends AbstractHelper
{
    protected $html;
    
    public function __invoke( $images , $base )
    {
        $this->html .= '<img class="bordered media-image-holder">';
        $this->html .= '<button class="left media-choose-image">Choose display image</button>';
        
        $this->html .= '<div class="media-window">';
            foreach( $images as $img )
            {
                $this->html .= '<img data-url="' . $img->url . '" class="bordered" src="' . $base . $img->url . '" />';
            }
        $this->html .= '</div>';
        
        return $this->html;
    }
}
