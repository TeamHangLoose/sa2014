<?php

namespace User\Form\User;

use Zend\InputFilter\InputFilter;
use ZfcUser\Options\AuthenticationOptionsInterface;

class ChangeAdressFilter extends InputFilter {

    public function __construct(AuthenticationOptionsInterface $options) {
        $identityParams = array(
            'name' => 'identity',
            'required' => true,
            'validators' => array()
        );

        $identityFields = $options->getAuthIdentityFields();
        if ($identityFields == array('email')) {
            $validators = array('name' => 'EmailAddress');
            array_push($identityParams['validators'], $validators);
        }

        $this->add($identityParams);

        $this->add(array(
            'name' => 'newUsername',
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
            'name' => 'newStreet',
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
            'name' => 'newPlz',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'regex',
                    'options' => array(
                        'pattern' => '/^[1-9][0-9][0-9][0-9]$/',
                        'messages' => array(
                            'regexNotMatch' => 'Ungültiges Format der PLZ',
                        ),
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'newVillage',
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
            'name' => 'newPhone',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'regex',
                    'options' => array(
                        'pattern' => '/^(?:(?:|0{1,2}|\+{0,2})41(?:|\(0\))|0)([1-9]\d)(\d{3})(\d{2})(\d{2})$/',
                        'messages' => array(
                            'regexNotMatch' =>'Ungültiges Format der Telefonnummer',
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'credential',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
        ));
    }

}
