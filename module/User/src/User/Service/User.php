<?php

namespace User\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author win7
 */
class User extends \ZfcUser\Service\User {

    public function changeAdress(array $data) {

        $currentUser = $this->getAuthService()->getIdentity();

        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $bcrypt->setCost($this->getOptions()->getPasswordCost());

        if (!$bcrypt->verify($data['credential'], $currentUser->getPassword())) {
            return false;
        }
        $currentUser->setStreet($data['newStreet']);
        $currentUser->setPlz($data['newPlz']);
        $currentUser->setVillage($data['newVillage']);

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));
        $this->getUserMapper()->update($currentUser);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $currentUser));

        return true;
    }
    
    public function register(array $data) {
        parent::register($data);
    }

}
