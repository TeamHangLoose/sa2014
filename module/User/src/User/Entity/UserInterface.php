<?php

namespace User\Entity;

interface UserInterface extends \ZfcUser\Entity\UserInterface {

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set id.
     *
     * @param int $id
     * @return UserInterface
     */
    public function setId($id);

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Set username.
     *
     * @param string $username
     * @return UserInterface
     */
    public function setUsername($username);

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param string $email
     * @return UserInterface
     */
    public function setEmail($email);

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName);

    /**
     * Get password.
     *
     * @return string password
     */
    public function getPassword();

    /**
     * Set password.
     *
     * @param string $password
     * @return UserInterface
     */
    public function setPassword($password);

    /**
     * Get state.
     *
     * @return String
     */
    public function getStreet();

    /**
     * Set Street.
     *
     * @param String $street
     * @return UserInterface
     */
    public function setStreet($street);

    /**
     * Get plz.
     *
     * @return String
     */
    public function getPlz();

    /**
     * Set plz.
     *
     * @param String $plz
     * @return UserInterface
     */
    public function setPlz($plz);

    /**
     * Get village.
     *
     * @return String
     */
    public function getVillage();

    /**
     * Set plz.
     *
     * @param String   $village
     * @return UserInterface
     */
    public function setVillage($village);

    /**
     * Get state.
     *
     * @return int
     */
    public function getState();

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state);

    function getActive();

    function setActive($active);
}
