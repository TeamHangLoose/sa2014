<?php

namespace User\Service;


use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Crypt\Password\Bcrypt;
use Zend\Stdlib\Hydrator;
use ZfcBase\EventManager\EventProvider;
use ZfcUser\Mapper\UserInterface as UserMapperInterface;
use ZfcUser\Options\UserServiceOptionsInterface;
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

        protected $doubleOptInService;
    
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
    
     public function register(array $data)
    {
        $class = $this->getOptions()->getUserEntityClass();
        $user  = new $class;
        $form  = $this->getRegisterForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }
        $user = $form->getData();
        /* @var $user \ZfcUser\Entity\UserInterface */

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
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('user' => $user, 'form' => $form));
        
        $OptInService->request($user->getEmail());
        
        return  true;
    }

         public function getDoubleOptInService()
    {
        if (!$this->doubleOptInService) {
            $this->doubleOptInService = $this->getServiceLocator()->get('User\Service\DoubleOptInService');
        }
        return $this->doubleOptInService;
    }
    
   
    

}
