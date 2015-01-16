<?php

namespace User\Mapper;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use ZfcUser\Entity\UserInterface;

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
     * Change password
     *
     * @param string $password
     * @param UserInterface $user
     * @return bool
     */
    public function setActive(UserInterface $user);

    public function setDisactive(UserInterface $user);

    public function setRole(UserInterface $user, $role);

    public function getRole($role);
    
    public function removeRole(UserInterface $user) ;

}
