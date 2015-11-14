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
        $this->html .= '<button class="left media-choose-image">Choose image</button>';
        
        $this->html .= '<div class="media-window">';
            $this->html .= '<h3 class="left dark-grey-text">Available media</h3>';
            foreach( $images as $img )
            {
                $this->html .= '<img data-url="' . $img->url . '" class="bordered" src="' . $base . $img->url . '" />';
            }
        $this->html .= '</div>';
        
        return $this->html;
    }
}
