<?php
namespace User\Factory\Controller;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Controller\DoubleOptInController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoubleOptInControllerFactory implements FactoryInterface
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
        $requestForm = $serviceLocator->get('User\Form\DoubleOptIn\RequestForm');

        /** @var \User\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('User\Form\DoubleOptIn\Confirmed');

        /** @var \User\Service\ForgotPasswordService $forgotPasswordService */
        $forgotPasswordService = $serviceLocator->get('User\Service\DoubleOptInService');

        return new DoubleOptInController($requestForm, $changePassword, $forgotPasswordService);
    }
}
