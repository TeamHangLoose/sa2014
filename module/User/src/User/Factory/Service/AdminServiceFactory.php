<?php

namespace User\Factory\Service;

use User\Service\AdminService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminServiceFactory implements FactoryInterface{  
    
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \User\Form\Forgot\ListForm $requestForm */
        $listForm = $serviceLocator->get('User\Form\Admin\ListForm');

        /** @var \User\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('User\Mapper\UserMapper');

        return new AdminService($listForm, $userMapper);
    }
}
