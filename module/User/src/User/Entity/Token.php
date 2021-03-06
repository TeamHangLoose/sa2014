<?php

namespace User\Entity;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tokens")
 */
class Token implements TokenInterface {

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $token;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $expireDateTime;

    public function __construct() {
        $this->token = uniqid(mt_rand(), true);
        $this->expireDateTime = null;
    }

    /**
     * @param int|null $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param int $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param \DateTime $expireDateTime
     */
    public function setExpireDateTime($expireDateTime) {
        $this->expireDateTime = $expireDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDateTime() {
        return $this->expireDateTime;
    }

}
