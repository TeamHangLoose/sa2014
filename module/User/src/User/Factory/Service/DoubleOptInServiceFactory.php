<?php

namespace User\Factory\Service;

use User\Service\DoubleOptInService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DoubleOptInServiceFactory
 *
 * @author win7
 */
class DoubleOptInServiceFactory implements FactoryInterface {

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
        return new DoubleOptInService($confirmed,$userMapper, $tokenMapper, $mailService,$zfcUserOptions);
    }

}
