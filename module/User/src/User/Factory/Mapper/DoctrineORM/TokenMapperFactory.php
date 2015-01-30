<?php

namespace User\Factory\Mapper\DoctrineORM;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use User\Mapper\DoctrineORM\TokenMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of TokenMapperFactory
 * Factory for TokenMapper
 * @author abbts2015 B14.if4.1 G.3
 */
class TokenMapperFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TokenMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('objectManager');

        /** @var \User\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');

        return new TokenMapper($objectManager, $moduleOptions);
    }

}
