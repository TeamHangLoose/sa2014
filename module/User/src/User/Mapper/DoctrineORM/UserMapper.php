<?php

namespace User\Mapper\DoctrineORM;

use Doctrine\Common\Persistence\ObjectManager;
use User\Mapper\UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator;

class UserMapper implements UserMapperInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var ZfcUserModuleOptions */
    protected $zfcUserModuleOptions;

    public function __construct(ObjectManager $objectManager, ZfcUserModuleOptions $zfcUserModuleOptions)
    {
        $this->objectManager = $objectManager;
        $this->zfcUserModuleOptions = $zfcUserModuleOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id)
    {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByEmail($email)
    {
        return $this->objectManager->getRepository($this->zfcUserModuleOptions->getUserEntityClass())->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function changePassword($password, UserInterface $user)
    {
        $bCrypt = new Bcrypt;
        $bCrypt->setCost($this->zfcUserModuleOptions->getPasswordCost());

        $password = $bCrypt->create($password);

        $user->setPassword($password);

        return $this->save($user);
    }

    
      public function findAll()
    {
        $select = $this->getSelect($this->tableName);
        $select->order(array('username ASC', 'display_name ASC', 'email ASC'));
        //$resultSet = $this->select($select);

        $resultSet = new HydratingResultSet($this->getHydrator(), $this->getEntityPrototype());
        $adapter = new Paginator\Adapter\DbSelect($select, $this->getSlaveSql(), $resultSet);
        $paginator = new Paginator\Paginator($adapter);

        return $paginator;
    }
    
    /**
     * Save user
     *
     * @param UserInterface $user
     * @param bool $flush
     * @return UserInterface
     */
    public function save(UserInterface $user, $flush = true)
    {
        $this->objectManager->persist($user);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $user;
    }
}
