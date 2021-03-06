<?php

namespace User\Service;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\Crypt\Password\Bcrypt;

/**
 * Description of UserService
 * UserService handel the User section
 * extends zfcUserService
 * overwritten functions are register 
 * @author abbts2015 B14.if4.1 G.3
 */
class User extends \ZfcUser\Service\User {

    /** @var DoubleOpInService $doubleOptInService */
    protected $doubleOptInService;

    public function isActive(array $data) {
        $currentUser = $this->getAuthService()->getIdentity();
        $user = $this->getUserMapper()->findByEmail($data['identity']);

        if (!$user) {
            return false;
        }
        if ($user->getActive()) {
            return true;
        }
        return false;
    }

    public function changeAdress(array $data) {
        $currentUser = $this->getAuthService()->getIdentity();
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $bcrypt->setCost($this->getOptions()->getPasswordCost());
        if (!$bcrypt->verify($data['credential'], $currentUser->getPassword())) {
            return false;
        }
        $currentUser->setDisplayName($data['newDisplayname']);
        $currentUser->setUsername($data['newUsername']);
        $currentUser->setStreet($data['newStreet']);
        $currentUser->setPlz($data['newPlz']);
        $currentUser->setVillage($data['newVillage']);
        $currentUser->setPhone($data['newPhone']);
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));
        $this->getUserMapper()->update($currentUser);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $currentUser));
        return true;
    }

    public function register(array $data) {
        $this->doubleOptInService = $this->getDoubleOptInService();
        $class = $this->getOptions()->getUserEntityClass();
        $user = new $class;
        $form = $this->getRegisterForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }
        $user = $form->getData();
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getOptions()->getPasswordCost());
        $user->setPassword($bcrypt->create($user->getPassword()));

        if ($this->getOptions()->getEnableUsername()) {
            $user->setUsername($data['username']);
        }
        if ($this->getOptions()->getEnableDisplayName()) {
            $user->setDisplayName($data['display_name']);
        }

        // If user state is enabled, set the default state value
        if ($this->getOptions()->getEnableUserState()) {
            if ($this->getOptions()->getDefaultUserState()) {
                $user->setState($this->getOptions()->getDefaultUserState());
            }
        }
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $user, 'form' => $form));
        $this->getUserMapper()->insert($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $user, 'form' => $form));
        return $user;
    }

    public function getDoubleOptInService() {
        if (!$this->doubleOptInService) {
            $this->doubleOptInService = $this->getServiceManager()->get('User\Service\DoubleOptInService');
        }
        return $this->doubleOptInService;
    }

}
