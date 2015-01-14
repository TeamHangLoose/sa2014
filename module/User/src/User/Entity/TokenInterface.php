<?php
namespace User\Entity;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
interface TokenInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return int
     */
    public function getUser();

    /**
     * @return \DateTime
     */
    public function getExpireDateTime();
}
