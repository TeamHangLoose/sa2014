<?php

namespace User\Factory\Mapper\DoctrineORM;

use User\Mapper\DoctrineORM\TokenMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TokenMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TokenMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('objectManager');

        /** @var \User\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');

        return new TokenMapper($objectManager, $moduleOptions);
    }
}