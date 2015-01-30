<?php

namespace User\Factory\Service;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use User\Service\AdminService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of AdminServiceFactory
 * Factory for AdminService
 * @author abbts2015 B14.if4.1 G.3
 */
class AdminServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AdminService
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /** @var \User\Form\Forgot\ListForm $requestForm */
        $listForm = $serviceLocator->get('User\Form\Admin\ListForm');
        /** @var \User\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('User\Mapper\UserMapper');
        return new AdminService($listForm, $userMapper);
    }

}
