<?php
namespace User\Form\User;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use ZfcBase\Form\ProvidesEventsForm;
use ZfcUser\Options\AuthenticationOptionsInterface;

class ChangeAdress extends ProvidesEventsForm {

    /**
     * @var AuthenticationOptionsInterface
     */
    protected $authOptions;

    public function __construct($name, AuthenticationOptionsInterface $options) {
        $this->setAuthenticationOptions($options);
        parent::__construct($name);


        $this->add(array(
            'name' => 'identity',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        $this->add(array(
            'name' => 'newUsername',
            'options' => array(
                'label' => 'Neuer Vor- und Nachname',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'newDisplayname',
            'options' => array(
                'label' => 'Neuer Benutzername',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'newStreet',
            'options' => array(
                'label' => 'Neue Strasse',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'newPlz',
            'options' => array(
                'label' => 'Neue Postleitzahl',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'newVillage',
            'options' => array(
                'label' => 'Neuer Ort',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'newPhone',
            'options' => array(
                'label' => 'Neue Telefonnummer',
            ),
            'attributes' => array(
                'type' => 'tel',
            ),
        ));

        $this->add(array(
            'name' => 'credential',
            'options' => array(
                'label' => 'Aktuelles Passwort',
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Submit',
                'type' => 'submit'
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    /**
     * Set Authentication-related Options
     *
     * @param AuthenticationOptionsInterface $authOptions
     * @return Login
     */
    public function setAuthenticationOptions(AuthenticationOptionsInterface $authOptions) {
        $this->authOptions = $authOptions;
        return $this;
    }

    /**
     * Get Authentication-related Options
     *
     * @return AuthenticationOptionsInterface
     */
    public function getAuthenticationOptions() {
        return $this->authOptions;
    }

}
