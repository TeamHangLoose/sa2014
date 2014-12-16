<?php

namespace User\Factory\Controller;

use User\Controller\AdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface{
  
    
      public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();

        /** @var \User\Form\Forgot\RequestForm $requestForm */
        $listForm = $serviceLocator->get('User\Form\Admin\ListForm');

        /** @var \User\Service\ForgotPasswordService $forgotPasswordService */
        $adminService = $serviceLocator->get('User\Service\AdminService');
        
           /** @var \User\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');

        return new AdminController($listForm, $adminService,$moduleOptions);
    }
}