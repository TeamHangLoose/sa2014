<?php

namespace User\Mapper\DoctrineORM;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Doctrine\Common\Persistence\ObjectManager;
use User\Mapper\UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Crypt\Password\Bcrypt;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Description of UserMapper
 * Mapper for User Entity
 * @author abbts2015 B14.if4.1 G.3
 */
class UserMapper implements EventManagerAwareInterface, UserMapperInterface {
    /* @var $events EventManager */

    protected $events;

    /** @var ObjectManager */
    protected $objectManager;

    /** @var ZfcUserModuleOptions */
    protected $zfcUserModuleOptions;

    /**
     * Constructor
     */
    public function __construct(ObjectManager $objectManager, ZfcUserModuleOptions $zfcUserModuleOptions) {
        $this->objectManager = $objectManager;
        $this->zfcUserModuleOptions = $zfcUserModuleOptions;
    }

    /**
     * find By ID
     *
     * @param String $id
     * @return User
     */
    public function findById($id) {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->find($id);
    }

    /**
     * find By Email
     *
     * @param String $email
     * @return User
     */
    public function findByEmail($email) {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->findOneBy([
                    'email' => $email,
        ]);
    }

    /**
     * change Password
     *
     * @param String $password
     * @param UserInterface $user
     * @return UserInterface
     */
    public function changePassword($password, UserInterface $user) {
        $bCrypt = new Bcrypt;
        $bCrypt->setCost($this->zfcUserModuleOptions->getPasswordCost());
        $password = $bCrypt->create($password);
        $user->setPassword($password);
        return $this->save($user);
    }

    /**
     * find all User
     * 
     * @return User Collection
     */
    public function findAll() {
        //$er = $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass());
        //return $er->findAll();
        $users = $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->findAll();
        return $users;
    }

    /**
     * Save user
     *
     * @param UserInterface $user
     * @param bool $flush
     * @return UserInterface
     */
    public function save(UserInterface $user, $flush = true) {
        $this->objectManager->persist($user);
        if ($flush) {
            $this->objectManager->flush();
        }
        return $user;
    }

    /**
     * Remove Role from User
     *
     * @param UserInterface $user
     */
    public function removeRole(UserInterface $user) {
        $roles = $user->getRoles();
        $roles->remove(0);
        $this->save($user);
    }

    /**
     * Remove user
     *
     * @param UserInterface $user
     */
    public function remove($user) {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $user));
        $this->objectManager->remove($user);
        $this->objectManager->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $user));
    }

    /**
     * set Active 
     *
     * @param UserInterface $user
     * @return UserInterface
     */
    public function setActive(UserInterface $user) {
        $user->setActive(true);
        return $this->save($user);
    }

    /**
     * set Disactive 
     *
     * @param UserInterface $user
     * @return UserInterface
     */
    public function setDisactive(UserInterface $user) {
        $user->setActive(false);
        return $this->save($user);
    }

    /**
     * set Role 
     *
     * @param UserInterface $user
     * @param Int $role
     * @return UserInterface
     */
    public function setRole(UserInterface $user, $role) {
        $userRole = $this->objectManager->getRepository('User\Entity\Role')->find($role);
        $user->getRoles()->add($userRole);
        return $this->save($user);
    }

    /**
     * get Role 
     *
     * @param Role $role
     * @return Role
     */
    public function getRole($role) {
        try {
            $userRole = $this->objectManager->getRepository('User\Entity\Role')->find($role);
        } catch (Exception $exc) {
            $userRole = $this->objectManager->getRepository('User\Entity\Role')->find(2);
        }
        return $userRole;
    }

    /**
     * get EventManager 
     * @return EventManager
     */
    public function getEventManager() {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    /**
     * set EventManager 
     * @param EventManagerInterface $event
     * @return EventManager
     */
    public function setEventManager(EventManagerInterface $events) {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

}
