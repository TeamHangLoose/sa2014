<?php
namespace User\Mapper;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use ZfcUser\Entity\UserInterface;
use User\Entity\TokenInterface;

/**
 * Description of TokenMapperInterface
 * Interface for different Token Mapper. 
 * @author abbts2015 B14.if4.1 G.3
 */
interface TokenMapperInterface
{
    /**
     * Generate token for user
     *
     * @param UserInterface $user
     * @return TokenInterface
     */
    public function generate(UserInterface $user);

    /**
     * Find token from user
     *
     * @param UserInterface $user
     * @return TokenInterface|null
     */
    public function findByUser(UserInterface $user);

    /**
     * Remove token
     *
     * @param TokenInterface $token
     * @return bool
     */
    public function remove(TokenInterface $token);

    /**
     * Get token entity by token
     *
     * @param $token
     * @return TokenInterface
     */
    public function findByToken($token);
}
