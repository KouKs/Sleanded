<?php
/**
 * Contact Form
 *
 * @author Mišel
 */
namespace Admin\Form;

use Zend\Form\Form;

class MediaForm extends Form
{
    public function __construct()
    {
        parent::__construct('dropzone');
        
        $this->add(array(
            'name' => 'file[]',
            'type' => 'text',
            'attributes' => array(
                'multiple' => 'multiple',
                'style'    => 'display: none',
            ),
        ));
    }
}