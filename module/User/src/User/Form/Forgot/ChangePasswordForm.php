<?php
namespace User\Form\Forgot;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ChangePasswordForm extends Form implements InputFilterProviderInterface
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('change-password');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'new_password',
            'type'  => 'Zend\Form\Element\Password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'password',
                'label' => 'Neues Passwort',

            ],
        ]);

        $this->add([
            'name' => 'confirm_new_password',
            'type'  => 'Zend\Form\Element\Password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'password',
                'label' => 'Neues Passwort bestätigen',

            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn btn-success',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'new_password',
                'required' => true,
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\StringLength',
                        'options' => [
                            'min' => '5',
                        ],
                        'messages' => [
                            \Zend\Validator\StringLength::TOO_SHORT => 'Ihr neues Passwort muss mindestens 5 Zeichen beinhalten',
                        ]
                    ],
                ],
            ],
            [
                'name' => 'confirm_new_password',
                'required' => true,
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\Identical',
                        'options' => [
                            'token' => 'new_password',
                        ],
                        'messages' => [
                            \Zend\Validator\Identical::NOT_SAME => 'Das Passwort stimmt nicht überein',
                        ]
                    ],
                ],
            ],
        ];
    }
}
