<?php

namespace User\Factory\Service;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use User\Service\DoubleOptInService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of DoubleOptInServiceFactory
 * Factory for DoubleOptInService
 * @author abbts2015 B14.if4.1 G.3
 */
class DoubleOptInServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return DoubleOptInService
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /** @var \User\Form\Forgot\ChangePasswordForm $changePassword */
        $confirmed = $serviceLocator->get('User\Form\DoubleOptIn\Confirmed');
        /** @var \User\Mapper\UserMapperInterface $userMapper */
        $userMapper = $serviceLocator->get('User\Mapper\UserMapper');
        /** @var \User\Mapper\TokenMapperInterface $tokenMapper */
        $tokenMapper = $serviceLocator->get('User\Mapper\TokenMapper');
        /** @var \User\Service\MailService $mailService */
        $mailService = $serviceLocator->get('User\Service\MailService');
        $zfcUserOptions = $serviceLocator->get('zfcuser_module_options');
        return new DoubleOptInService($confirmed, $userMapper, $tokenMapper, $mailService, $zfcUserOptions);
    }

}
