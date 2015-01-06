<?php

namespace User\Form\htProfileImage;

use Zend\Form\Form;
use ZfcBase\Form\ProvidesEventsForm;

class ProfileImageForm extends ProvidesEventsForm {

    public function __construct() {
        parent::__construct('profile_image_upload');
        $this->setAttribute('class', 'image_upload_form');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add([
            'name' => 'image',
            'type' => 'File',
            'class'=>'img-circle',
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
