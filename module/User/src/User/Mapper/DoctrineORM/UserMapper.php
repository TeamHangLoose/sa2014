<?php

namespace User\Mapper\DoctrineORM;

use Doctrine\Common\Persistence\ObjectManager;
use User\Mapper\UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Crypt\Password\Bcrypt;
use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

class UserMapper implements EventManagerAwareInterface, UserMapperInterface {

    protected $events;

    /** @var ObjectManager */
    protected $objectManager;

    /** @var ZfcUserModuleOptions */
    protected $zfcUserModuleOptions;

    public function __construct(ObjectManager $objectManager, ZfcUserModuleOptions $zfcUserModuleOptions) {
        $this->objectManager = $objectManager;
        $this->zfcUserModuleOptions = $zfcUserModuleOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id) {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByEmail($email) {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->findOneBy([
                    'email' => $email,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function changePassword($password, UserInterface $user) {
        $bCrypt = new Bcrypt;
        $bCrypt->setCost($this->zfcUserModuleOptions->getPasswordCost());
        $password = $bCrypt->create($password);
        $user->setPassword($password);
        return $this->save($user);
    }

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



    public function remove($entity) {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $entity));
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $entity));
    }

    public function getEventManager() {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function setEventManager(EventManagerInterface $events) {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setActive(UserInterface $user) {
        $user->setActive(true);
        return $this->save($user);
    }

    public function setDisactive(UserInterface $user) {
        $user->setActive(false);
        return $this->save($user);
    }

    public function setRole(UserInterface $user, $role) {
        $userRole = $this->objectManager->getRepository('User\Entity\Role')->find($role);
        $user->getRoles()->add($userRole);
        return $this->save($user);
    }

    public function getRole($role) {
        try {
            $userRole = $this->objectManager->getRepository('User\Entity\Role')->find($role);
        } catch (Exception $exc) {
            $userRole = $this->objectManager->getRepository('User\Entity\Role')->find(2);
        }


        return $userRole;
    }

}
