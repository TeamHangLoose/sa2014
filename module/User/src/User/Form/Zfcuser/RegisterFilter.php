<?php

namespace User\Form\Zfcuser;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use ZfcUser\Module as ZfcUser;
use ZfcUser\Options\RegistrationOptionsInterface;

class RegisterFilter extends ProvidesEventsInputFilter {

    protected $emailValidator;
    protected $usernameValidator;

    /**
     * @var RegistrationOptionsInterface
     */
    protected $options;

    public function __construct($emailValidator, $usernameValidator, RegistrationOptionsInterface $options) {
        $this->setOptions($options);
        $this->emailValidator = $emailValidator;
        $this->usernameValidator = $usernameValidator;

        if ($this->getOptions()->getEnableUsername()) {
            $this->add(array(
                'name' => 'username',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 255,
                        ),
                    ),
                    $this->usernameValidator,
                ),
            ));
        }

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
                $this->emailValidator
            ),
        ));

        if ($this->getOptions()->getEnableDisplayName()) {
            $this->add(array(
                'name' => 'display_name',
                'required' => true,
                'filters' => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 128,
                        ),
                    ),
                ),
            ));
        }

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'displayname',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 128,
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'Street',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'plz',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'regex',
                    'options' => array(
                        'pattern' => '/^[1-9][0-9][0-9][0-9]$/',
                        'messages' => array(
                            'regexNotMatch' => 'Ungültige Postleitzahl',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'village',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 50,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'regex',
                    'options' => array(
                        'pattern' => '/^(?:(?:|0{1,2}|\+{0,2})41(?:|\(0\))|0)([1-9]\d)(\d{3})(\d{2})(\d{2})$/',
                        'messages' => array(
                            'regexNotMatch' => 'Ungültiges Format der Telefonnummer',
                        ),
                    ),
                ),
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    public function getEmailValidator() {
        return $this->emailValidator;
    }

    public function setEmailValidator($emailValidator) {
        $this->emailValidator = $emailValidator;
        return $this;
    }

    public function getUsernameValidator() {
        return $this->usernameValidator;
    }

    public function setUsernameValidator($usernameValidator) {
        $this->usernameValidator = $usernameValidator;
        return $this;
    }

    /**
     * set options
     *
     * @param RegistrationOptionsInterface $options
     */
    public function setOptions(RegistrationOptionsInterface $options) {
        $this->options = $options;
    }

    /**
     * get options
     *
     * @return RegistrationOptionsInterface
     */
    public function getOptions() {
        return $this->options;
    }

}
