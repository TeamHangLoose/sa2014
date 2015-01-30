<?php
namespace User\Factory\Options;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ModuleOptionsFactory
 * Factory for ModuleOptions
 * @author abbts2015 B14.if4.1 G.3
 */
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
