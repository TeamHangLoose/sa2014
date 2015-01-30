<?php

namespace User\Factory\Controller;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use User\Controller\ForgotPasswordController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ForgotPasswordControllerFactory
 * Factory for ForgotPasswordController
 * @author abbts2015 B14.if4.1 G.3
 */
class ForgotPasswordControllerFactory implements FactoryInterface {

    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return ForgotPasswordController
     */
    public function createService(ServiceLocatorInterface $controllerManager) {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();
        /** @var \User\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('User\Form\Forgot\RequestForm');
        /** @var \User\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('User\Form\Forgot\ChangePasswordForm');
        /** @var \User\Service\ForgotPasswordService $forgotPasswordService */
        $forgotPasswordService = $serviceLocator->get('User\Service\ForgotPasswordService');
        return new ForgotPasswordController($requestForm, $changePassword, $forgotPasswordService);
    }

}
