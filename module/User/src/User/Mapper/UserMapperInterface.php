<?php

namespace User\Mapper;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use ZfcUser\Entity\UserInterface;

/**
 * Description of UserMapperInterface
 * Interface for different User Mapper. 
 * @author abbts2015 B14.if4.1 G.3
 */

interface UserMapperInterface {

    /**
     * Find user by email
     *
     * @param string $email
     * @return UserInterface
     */
    public function findByEmail($email);

    /**
     * Find user by id
     *
     * @param int $id
     * @return UserInterface
     */
    public function findById($id);

    /**
     * Change password
     *
     * @param string $password
     * @param UserInterface $user
     * @return bool
     */
    public function changePassword($password, UserInterface $user);

    /**
     * Set active
     * @param UserInterface $user 
     */
    public function setActive(UserInterface $user);

    /**
     * Set Disactive
     * @param UserInterface $user 
     */
    public function setDisactive(UserInterface $user);

    /**
     * Set Role
     * @param UserInterface $user 
     * @param int Role
     */
    public function setRole(UserInterface $user, $role);

    /**
     * Set Role
     * @param int Role
     * @retur Entity Role 
     */
    public function getRole($role);

    /**
     * Set Role
     * @param UserInterface $user 
     */
    public function removeRole(UserInterface $user);
}
