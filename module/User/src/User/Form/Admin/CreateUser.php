<?php

namespace User\Form\Admin;

use User\Options\UserCreateOptionsInterface;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUser\Form\Register as Register;
use Zend\Form\Element;

class CreateUser extends Register {

    /**
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;
    protected $serviceManager;

    public function __construct($name, RegistrationOptionsInterface $registerOptions) {


        $this->setRegistrationOptions($registerOptions);

        parent::__construct($name, $registerOptions);

        //$this->remove('userId');
        /*
         * foreach for the modulOption SampelCode edit arra do you want...   
          foreach ($this->getCreateOptions()->getCreateFormElements() as $name => $element) {
          // avoid adding fields twice (e.g. email)
          // if ($this->get($element)) continue;
          $this->add(array(
          'name' => $element,
          'options' => array(
          'label' => $name,
          ),
          'attributes' => array(
          'type' => 'text',
          ),
          ));
          }
         */

        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha() && $this->captchaElement) {
            $this->add($this->captchaElement, array('name' => 'captcha'));
        }


        $this->remove('display_name');
        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Vor- und Nachname',),
            'attributes' => array(
                'type' => 'text',),
            'required',
                )
        );

        $this->add(array(
            'name' => 'street',
            'options' => array(
                'label' => 'Strasse und Hausnummer',),
            'attributes' => array(
                'type' => 'text',),
            'required',
                )
        );

        $this->add(array(
            'name' => 'plz',
            'options' => array(
                'label' => 'Postleitzahl',),
            'attributes' => array(
                'type' => 'text',),
            'required',
                )
        );
        $this->add(array(
            'name' => 'village',
            'options' => array(
                'label' => 'Ort',),
            'attributes' => array(
                'type' => 'text',),
            'required',
                )
        );

        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Telefon',),
            'attributes' => array(
                'type' => 'tel',
                'required'
            ),
                )
        );
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'active',
            'options' => array(
                'label' => 'User aktivieren',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role',
            'options' => array(
                'label' => 'Berechtigung',
                'value_options' => array(
                    '1' => 'Guest',
                    '2' => 'User',
                    '3' => 'Admin',
                ),
            )
        ));

        $this->get('submit')->setLabel('Register');
        $this->getEventManager()->trigger('init', $this);
    }

}
