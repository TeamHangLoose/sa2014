<?php
namespace User\Form\Admin;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ListForm extends Form implements InputFilterProviderInterface
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('list');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'email',
            'type'  => 'Zend\Form\Element\Text',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'email',
                'label' => 'Email',

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
                'name' => 'email',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ],
                ],
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\EmailAddress',
                        'options' => [
                            'domain' => false,
                        ],
                    ],
                ],
            ],
        ];
    }
}
