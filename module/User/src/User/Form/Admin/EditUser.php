<?php
namespace User\Form\Admin;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use ZfcUser\Entity\UserInterface;
use ZfcUser\Form\Register;
use ZfcUser\Options\RegistrationOptionsInterface;
use User\Options\UserEditOptionsInterface;

class EditUser extends Register {

    /**
     * @var \ZfcUserAdmin\Options\UserEditOptionsInterface
     */
    protected $userEditOptions;
    protected $userEntity;
    protected $serviceManager;

    public function __construct($name = null, UserEditOptionsInterface $options, RegistrationOptionsInterface $registerOptions, $serviceManager) {
        $this->setUserEditOptions($options);
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        $this->remove('captcha');
        if ($this->userEditOptions->getAllowPasswordChange()) {
            $this->add(array(
                'name' => 'reset_password',
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'label' => 'Zufälliges Passwort generieren',
                ),
            ));

            $password = $this->get('password');
            $password->setAttribute('required', false);
            $password->setOptions(array('label' => 'Passwort (Nur wenn Sie es ändern wollen)'));

            $this->remove('passwordVerify');
        } else {
            $this->remove('password')->remove('passwordVerify');
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
        $this->add(array(
            'name' => 'userId',
            'attributes' => array(
                'type' => 'hidden'
            ), 'options' => array(
                'label' => '',
            )
        ));

        $this->get('submit')->setLabel('Speichern')->setValue('Speichern');
    }

    public function setUser($userEntity) {
        $this->userEntity = $userEntity;
        $this->getEventManager()->trigger('userSet', $this, array('user' => $userEntity));
    }

    public function getUser() {
        return $this->userEntity;
    }

    public function populateFromUser(UserInterface $user) {
        foreach ($this->getElements() as $element) {
            /** @var $element \Zend\Form\Element */
            $elementName = $element->getName();
            if (strpos($elementName, 'password') === 0)
                continue;

            $getter = $this->getAccessorName($elementName, false);
            if (method_exists($user, $getter))
                $element->setValue(call_user_func(array($user, $getter)));
        }

        foreach ($this->getUserEditOptions()->getEditFormElements() as $element) {
            $getter = $this->getAccessorName($element, false);
            $this->get($element)->setValue(call_user_func(array($user, $getter)));
        }
        $this->get('userId')->setValue($user->getId());
    }

    protected function getAccessorName($property, $set = true) {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }

    public function setUserEditOptions(UserEditOptionsInterface $userEditOptions) {
        $this->userEditOptions = $userEditOptions;
        return $this;
    }

    public function getUserEditOptions() {
        return $this->userEditOptions;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

}
