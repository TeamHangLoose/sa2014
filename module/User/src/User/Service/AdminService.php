<?php

namespace User\Service;

use User\Mapper\UserMapperInterface;
use Zend\Form\Form;
use Zend\Math\Rand;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class AdminService extends EventProvider implements ServiceManagerAwareInterface {

    /** @var listForm */
    protected $listForm;

    /** @var UserMapperInterface */
    protected $userMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(\User\Form\Admin\ListForm $listForm, UserMapperInterface $userMapper) {
        $this->listForm = $listForm;
        $this->userMapper = $userMapper;
    }

    /**
     * Request new password
     *
     * @param array $data
     * @return bool
     */
    public function listUser() {
        $users = $this->userMapper->findAll();
        return $users;
    }

    public function create(Form $form, array $data, $zfcUserOptions, $modulOptions) {

        //$zfcUserOptions = $this->getZfcUserOptions();
        $user = $form->getData();

        $argv = array();
        if ($modulOptions->getCreateUserAutoPassword()) {
            $argv['password'] = $this->generatePassword($modulOptions);
        } else {
            $argv['password'] = $user->getPassword();
        }
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($zfcUserOptions->getPasswordCost());
        $user->setPassword($bcrypt->create($argv['password']));

        foreach ($modulOptions->getCreateFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }

        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->userMapper->save($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * @return string
     */
    public function generatePassword($modulOptions) {
        return Rand::getString($modulOptions->getAutoPasswordLength());
    }

}
