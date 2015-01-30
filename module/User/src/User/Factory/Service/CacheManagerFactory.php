<?php

namespace User\Factory\Service;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Service\CacheManager;

/**
 * Description of CacheManagerFactory
 * Factory for CacheManager
 * @author abbts2015 B14.if4.1 G.3
 */
class CacheManagerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CacheManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new CacheManager(
                $serviceLocator->get('HtImgModule\Service\CacheManager'), $serviceLocator->get('HtProfileImage\StorageModel')
        );
    }

}
