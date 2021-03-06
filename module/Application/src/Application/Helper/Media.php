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
    
    public function __invoke( $images , $base , $onlyTab = false )
    {
        if( $onlyTab )
        {
            $this->html = '<div class="media-window-tab">';
                $this->html .= '<h3 class="left dark-grey-text">Available media</h3>';
                $this->html .= '<div class="grid">';
                    foreach( $images as $img )
                    {
                        $this->html .= '<img data-url="' . $img["url"] . '" class="bordered grid-item" src="' . $base . $img["url"] . '" />';
                    }
                $this->html .= '</div>';
            $this->html .= '</div>';
        }
        else
        {
            $this->html = '<img class="bordered media-image-holder">';
            $this->html .= '<button class="left media-choose-image">Choose image</button>';

            $this->html .= '<div class="media-window">';
                $this->html .= '<h3 class="left dark-grey-text">Available media</h3>';
                $this->html .= '<div class="grid">';
                    foreach( $images as $img )
                    {
                        $this->html .= '<img data-url="' . $img["url"] . '" class="bordered grid-item" src="' . $base . $img["url"] . '" />';
                    }
                $this->html .= '</div>';
            $this->html .= '</div>';
        }
        
        return $this->html;
    }
}
