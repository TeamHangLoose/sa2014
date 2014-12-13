<?php

namespace User\Factory\Options;

use User\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create options
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $boardConfig = [];

        if (isset($config['User']['forgot-password'])) {
            $boardConfig = $config['User']['forgot-password'];
        }

        $options = new ModuleOptions($boardConfig);

        return $options;
    }
}
