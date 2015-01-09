<?php

namespace User\Form\Admin;

use User\Options\UserCreateOptionsInterface;
use User\Options\RegistrationOptionsInterface;
use ZfcUser\Form\Register as Register;

class CreateUser extends Register {

    /**
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;
    protected $serviceManager;

    /**
     * @var UserCreateOptionsInterface
     */
    protected $createOptions;

    public function __construct($name = null, \User\Options\ModuleOptions $createOptions, \ZfcUser\Options\ModuleOptions $registerOptions, $serviceManager) {
        $this->setCreateOptions($createOptions);
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        if ($createOptions->getCreateUserAutoPassword()) {
            $this->remove('password');
            $this->remove('passwordVerify');
        }

        /*
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

        $this->get('submit')->setLabel('Register');
        $this->getEventManager()->trigger('init', $this);
    }

    public function setCreateOptions(UserCreateOptionsInterface $createOptionsOptions) {
        $this->createOptions = $createOptionsOptions;
        return $this;
    }

    public function getCreateOptions() {
        return $this->createOptions;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

}