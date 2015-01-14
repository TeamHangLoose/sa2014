<?php
namespace User\Factory\Service;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Service\ProfileImageService;

class ProfileImageServiceFactory implements FactoryInterface
{
    /**
     * gets ProfileImageService Service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ProfileImageService
     */
     public function createService(ServiceLocatorInterface $sm)
     {
        $service = new ProfileImageService();
        $service->setServiceLocator($sm);

        return $service;
     }
}
