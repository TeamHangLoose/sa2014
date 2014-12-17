<?php

namespace User\Factory\Controller;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use User\Controller\ProfileImageController;

class ProfileImageControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $serviceLocator = $controllers->getServiceLocator();
        $service = $serviceLocator->get('HtProfileImage\Service\ProfileImageService');

        return new ProfileImageController($service);
    }
}
