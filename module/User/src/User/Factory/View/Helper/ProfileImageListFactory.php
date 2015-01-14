<?php
namespace User\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\View\Helper\ProfileImageList;

class ProfileImageListFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $helpers)
    {
        $serviceLocator = $helpers->getServiceLocator();
        $options = $serviceLocator->get('HtProfileImage\ModuleOptions');
        $helper = new ProfileImageList(
            $options,
            $serviceLocator->get('HtProfileImage\StorageModel'),
            $serviceLocator->get('zfcuser_user_mapper')
        );
        if ($options->getEnableCache()) {
            $helper->setCacheManager($serviceLocator->get('HtProfileImage\Service\CacheManager'));
        }

        return $helper;
    }
}