<?php
/**
 * Profile edit form
 *
 * @author kouks
 */
namespace Admin\Form;

use Zend\Form\Form;

class ProfileEditForm extends Form
{
    public function __construct( $desc = null , $checked = false )
    {
        parent::__construct('profile-edit');
        
        $desc = isset( $desc ) ? $desc : "";
        $checked = $checked ? "checked" : "";
        $this->add(array(
            'name' => 'desc',
            'type' => 'textarea',
            'attributes' => array(
                // TODO: TRANSLATION
                'placeholder' => 'Something about yourself',
                'value' => $desc,
            ),
        ));
        $this->add(array(
            'name' => 'img',
            'type' => 'Zend\Form\Element\File',
            'label' => 'Profile image displayed on team page',
        ));
        $this->add(array(
            'name' => 'displayed',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'checked_value' => 1,
                'unchecked_value' => 0,
                'checked' => $checked
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'hvr-grow'
             ),
        ));
    }
}