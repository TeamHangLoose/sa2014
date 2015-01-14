<?php
namespace User\Form\htProfileImage;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use ZfcBase\Form\ProvidesEventsForm;

class ProfileImageForm extends ProvidesEventsForm {

    public function __construct() {
        parent::__construct('profile_image_upload');
        $this->setAttribute('class', 'image_upload_form');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add([
            'name' => 'image',
            'type' => 'File',
            
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Upload',
                'class' => 'btn btn-success'
            ],
        ]);

        $this->getEventManager()->trigger('init', $this);
    }

}
