<?php
namespace User\Factory\Mapper\DoctrineORM;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Mapper\DoctrineORM\UserMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('objectManager');
        /** @var \ZfcUser\Options\ModuleOptions $zfcUserModuleOptions */
        $zfcUserModuleOptions = $serviceLocator->get('zfcuser_module_options');
        return new UserMapper($objectManager, $zfcUserModuleOptions);
    }
}
