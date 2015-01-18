<?php

namespace User\Options;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements
ModuleOptionsInterface, UserListOptionsInterface, UserEditOptionsInterface, UserCreateOptionsInterface {

    /** @var string */
    protected $tokenEntity = 'User\Entity\Token';

    /** @var int */
    protected $tokenHours = 24;


    /**
     * @var string
     */
    protected $mailTransporter = 'Soflomo\Mail\Service\MailService';

    /**
     * Ensure that the entity has the correct name
     *
     * @param $entityClass
     * @return string
     */
    protected $__strictMode__ = false;
    
    /* @var $numberOfListLines List of disp. Admin */
    protected $numberOfListLines = 15;

    /**
     * Array of data to show in the user list
     * Key = Label in the list
     * Value = entity property(expecting a 'getProperty())
     */
    protected $userListElements = array(
        'Id' => 'id',
        'Name' => 'username',
        'Email address' => 'email',
        'Street' => 'street',
        'Zip Code' => 'plz',
        'Village' => 'village',
        'Phone' => 'phone',
        'Aktive' => 'active');

    /**
     * Array of form elements to show when editing a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $editFormElements = array(
            /*
              'Vorname Nachname' => 'username',
              'Email' => 'email',
              'Strasse' => 'street',
              'PLZ' => 'plz',
              'Ort' => 'village',
              'Telefon' => 'phone'
             */
    );

    /**
     * Array of form elements to show when creating a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $createFormElements = array(
            /*
              //ID hidden
              'Vorname Nachname' => 'username',
              'Strasse' => 'street',
              'PLZ' => 'plz',
              'Ort' => 'village',
              'Telefon' => 'phone'
             */
    );

    /**
     * @var bool
     * true = create password automaticly
     * false = administrator chooses password
     */
    protected $createUserAutoPassword = false;

    /**
     * @var int
     * Length of passwords created automatically
     */
    protected $autoPasswordLength = 8;

    /**
     * @var bool
     * Allow change user password on user edit form.
     */
    protected $allowPasswordChange = true;
    
    protected $userMapper = 'ZfcUserAdmin\Mapper\UserDoctrine';

    function get__strictMode__() {
        return $this->__strictMode__;
    }

    function getNumberOfListLines() {
        return $this->numberOfListLines;
    }

    function set__strictMode__($__strictMode__) {
        $this->__strictMode__ = $__strictMode__;
    }

    function setNumberOfListLines($numberOfListLines) {
        $this->numberOfListLines = $numberOfListLines;
    }

    public function correctEntity($entityClass) {
        if (substr($entityClass, 0, 1) !== '\\') {
            $entityClass = '\\' . $entityClass;
        }

        return $entityClass;
    }

    /**
     * @param string $tokenEntity
     */
    public function setTokenEntity($tokenEntity) {
        $this->tokenEntity = $tokenEntity;
    }

    /**
     * @return string
     */
    public function getTokenEntity() {
        return $this->correctEntity($this->tokenEntity);
    }

    /**
     * @param int $tokenHours
     */
    public function setTokenHours($tokenHours) {
        $this->tokenHours = $tokenHours;
    }

    /**
     * @return int
     */
    public function getTokenHours() {
        return $this->tokenHours;
    }

    /**
     * @param string $mailTransporter
     */
    public function setMailTransporter($mailTransporter) {
        $this->mailTransporter = $mailTransporter;
    }

    /**
     * @return string
     */
    public function getMailTransporter() {
        return $this->mailTransporter;
    }

    public function setUserMapper($userMapper) {
        $this->userMapper = $userMapper;
    }

    public function getUserMapper() {
        return $this->userMapper;
    }

    public function setUserListElements(array $listElements) {
        $this->userListElements = $listElements;
    }

    public function getUserListElements() {
        return $this->userListElements;
    }

    public function getEditFormElements() {
        return $this->editFormElements;
    }

    public function setEditFormElements(array $elements) {
        $this->editFormElements = $elements;
    }

    public function setCreateFormElements(array $createFormElements) {
        $this->createFormElements = $createFormElements;
    }

    public function getCreateFormElements() {
        return $this->createFormElements;
    }

    public function setCreateUserAutoPassword($createUserAutoPassword) {
        $this->createUserAutoPassword = $createUserAutoPassword;
    }

    public function getCreateUserAutoPassword() {
        return $this->createUserAutoPassword;
    }

    public function getAllowPasswordChange() {
        return $this->allowPasswordChange;
    }

    public function setAdminPasswordChange($allowPasswordChange) {
        $this->allowPasswordChange = $allowPasswordChange;
    }

    public function setAutoPasswordLength($autoPasswordLength) {
        $this->autoPasswordLength = $autoPasswordLength;
    }

    public function getAutoPasswordLength() {
        return $this->autoPasswordLength;
    }

}
