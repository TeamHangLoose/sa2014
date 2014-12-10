<?php

namespace User\Factory\Controller;

use User\Service\ForgotPasswordService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ForgotPasswordService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Mapper\UserMapper');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapperInterface $tokenMapper */
        $tokenMapper = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Mapper\TokenMapper');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\MailService $mailService */
        $mailService = $serviceLocator->get('Eye4web\ZfcUser\ForgotPassword\Service\MailService');

        return new ForgotPasswordService($requestForm, $changePassword, $userMapper, $tokenMapper, $mailService);
    }
}
