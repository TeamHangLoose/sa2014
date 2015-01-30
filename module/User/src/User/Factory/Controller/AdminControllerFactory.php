<?php

namespace User\Factory\Controller;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use User\Controller\AdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of AdminControllerFactory
 * Factory for AdminController
 * @author abbts2015 B14.if4.1 G.3
 */
class AdminControllerFactory implements FactoryInterface {

    /**
     * Create controller
     * 
     * @param ServiceLocatorInterface $controllerManager
     * @return AdminController
     */
    public function createService(ServiceLocatorInterface $controllerManager) {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();
        /** @var \User\Form\Forgot\RequestForm $requestForm */
        $listForm = $serviceLocator->get('User\Form\Admin\ListForm');
        /** @var \User\Service\ForgotPasswordService $forgotPasswordService */
        $adminService = $serviceLocator->get('User\Service\AdminService');
        /** @var \User\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');
        /** @var \ZfcUser\Options\ModuleOptions 'zfcuser_module_options' */
        $zfcUserOptions = $serviceLocator->get('zfcuser_module_options');
        return new AdminController($listForm, $adminService, $moduleOptions, $zfcUserOptions);
    }

}
