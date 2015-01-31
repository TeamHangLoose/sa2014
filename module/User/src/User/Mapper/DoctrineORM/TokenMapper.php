<?php

namespace User\Mapper\DoctrineORM;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\TokenInterface;
use User\Mapper\TokenMapperInterface;
use User\Options\ModuleOptions;
use ZfcUser\Entity\UserInterface;

/**
 * Description of TokenMapper
 * Mapper for Token Entity use for DoubleOptIn or Password forgot ect.
 * @author abbts2015 B14.if4.1 G.3
 */
class TokenMapper implements TokenMapperInterface {

    /** @var ObjectManager $objectManager */
    protected $objectManager;

    /** @var ModuleOptions $moduleOptions*/
    protected $moduleOptions;

    /**
     * Constructor
     * @param ObjectManager $objectManager
     * @param ModuleOptions $moduleOptions
     */
    public function __construct(ObjectManager $objectManager, ModuleOptions $moduleOptions) {
        $this->objectManager = $objectManager;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * find By User
     *
     * @param UserInterface $user
     * @return Token Entity
     */
    public function findByUser(UserInterface $user) {
        return $this->objectManager->getRepository($this->moduleOptions->getTokenEntity())->findOneBy([
                    'user' => $user->getId()
        ]);
    }

    /**
     * find By Token
     *
     * @param String $token
     * @return boolean
     */
    public function findByToken($token) {
        $queryBuilder = $this->objectManager->createQueryBuilder();

        $queryBuilder->select('t')
                ->from($this->moduleOptions->getTokenEntity(), 't')
                ->where('t.token = :token')
                ->andWhere('t.expireDateTime > :current');

        /** @var \Doctrine\ORM\AbstractQuery $query */
        $query = $queryBuilder->getQuery();

        $query->setParameters([
            'token' => $token,
            'current' => new \DateTime
        ]);

        return $query->getOneOrNullResult();
    }

    /**
     * generate Token
     *
     * @param UserInterface $user
     * @return TokenInterface
     */
    public function generate(UserInterface $user) {
        if ($token = $this->findByUser($user)) {
            $this->remove($token);
        }

        $entity = $this->moduleOptions->getTokenEntity();
        /** @var TokenInterface $token */
        $token = new $entity;

        // Expire
        $hours = $this->moduleOptions->getTokenHours();
        $hoursText = 'hours';

        if ($hours == 1) {
            $hoursText = 'hour';
        }

        $expire = new \DateTime;
        $expire->modify('+' . $hours . ' ' . $hoursText);

        $token->setUser($user->getId());
        $token->setExpireDateTime($expire);

        return $this->saveToken($token);
    }

    /**
     * remove Token
     *
     * @param UserInterface $user
     * @param bool $flush
     * @return TokenInterface
     */
    public function remove(TokenInterface $token, $flush = true) {
        $this->objectManager->remove($token);

        if ($flush) {
            $this->objectManager->flush();
        }

        return true;
    }

    /**
     * Save token
     *
     * @param TokenInterface $token
     * @param bool $flush
     * @return TokenInterface
     */
    public function saveToken(TokenInterface $token, $flush = true) {
        $this->objectManager->persist($token);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $token;
    }

}
