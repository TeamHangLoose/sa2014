<?php

namespace User\Factory\View\Helper;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\View\Helper\ProfileImage;

/**
 * Description of ProfileImageFactory
 * Factory for ProfileImage
 * @author abbts2015 B14.if4.1 G.3
 */
class ProfileImageFactory implements FactoryInterface {

    /**
     * Create Helper
     *
     * @param ServiceLocatorInterface $helpers
     * @return ProfileImage
     */
    public function createService(ServiceLocatorInterface $helpers) {
        $serviceLocator = $helpers->getServiceLocator();
        $options = $serviceLocator->get('HtProfileImage\ModuleOptions');
        $helper = new ProfileImage(
                $options, $serviceLocator->get('HtProfileImage\StorageModel'), $serviceLocator->get('zfcuser_user_mapper')
        );
        if ($options->getEnableCache()) {
            $helper->setCacheManager($serviceLocator->get('HtProfileImage\Service\CacheManager'));
        }

        return $helper;
    }

}
