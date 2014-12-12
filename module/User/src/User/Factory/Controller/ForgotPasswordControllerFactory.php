<?php

namespace User\Factory\Controller;

use User\Controller\ForgotPasswordController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordControllerFactory implements FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return ForgotPasswordController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
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
