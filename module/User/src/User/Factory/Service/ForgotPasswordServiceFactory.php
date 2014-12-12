<?php

namespace User\Factory\Service;

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
        /** @var \User\Form\Forgot\RequestForm $requestForm */
        $requestForm = $serviceLocator->get('User\Form\Forgot\RequestForm');

        /** @var \User\Form\Forgot\ChangePasswordForm $changePassword */
        $changePassword = $serviceLocator->get('User\Form\Forgot\ChangePasswordForm');

        /** @var \User\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('User\Mapper\UserMapper');

        /** @var \User\Mapper\TokenMapperInterface $tokenMapper */
        $tokenMapper = $serviceLocator->get('User\Mapper\TokenMapper');

        /** @var \User\Service\MailService $mailService */
        $mailService = $serviceLocator->get('User\Service\MailService');

        return new ForgotPasswordService($requestForm, $changePassword, $userMapper, $tokenMapper, $mailService);
    }
}
