<?php

return array(
    'aliases' => array(
        'objectManager' => 'Doctrine\ORM\EntityManager',
        'Soflomo\Mail\Renderer' => 'ViewRenderer',
        'Soflomo\Mail\Transport' => 'Soflomo\Mail\DefaultTransport',
        'Soflomo\Mail\Message' => 'Soflomo\Mail\DefaultMessage',
    ),
    'invokables' => array(
        'User\Form\Forgot\RequestForm' => 'User\Form\Forgot\RequestForm',
        'User\Form\DoubleOptIn\RequestForm' => 'User\Form\DoubleOptIn\RequestForm',
        'User\Form\DoubleOptIn\Confirmed' => 'User\Form\DoubleOptIn\Confirmed',
        'User\Form\Forgot\ChangePasswordForm' => 'User\Form\Forgot\ChangePasswordForm',
        'User\Form\Admin\ListForm' => 'User\Form\Admin\ListForm',
        'User\Form\Admin\EditUser' => 'User\Form\Admin\EditUser',
        'User\Form\Admin\CreateUser' => 'User\Form\Admin\CreateUser',
        'zfcuser_user_service' => 'User\Service\User',
        'HtProfileImage\ProfileImageForm' => 'User\Form\htProfileImage\ProfileImageForm',
        'ZfcUser\Form\Register' => 'User\Form\Admin\EditUser',
        'User\Form\ZfcUser\Register' => 'User\Form\ZfcUser\Register',
        'User\Form\User\Index' => 'User\Form\User\Index',
        'HtProfileImage\ProfileImage' => 'User\Controller\ProfileImageController',
    ),
    'initializers' => array(
        'mail_transport' => 'Soflomo\Mail\Service\TransportAwareInitializer',
        'mail_message' => 'Soflomo\Mail\Service\MessageAwareInitializer',
    ),
    'shared' => array(
        'Soflomo\Mail\DefaultMessage' => false,
    ),
    'factories' => array(
        'User\Service\ForgotPasswordService' => 'User\Factory\Service\ForgotPasswordServiceFactory',
        'User\Service\MailService' => 'User\Factory\Service\MailServiceFactory',
        'User\Options\ModuleOptions' => 'User\Factory\Options\ModuleOptionsFactory',
        'User\Service\AdminService' => 'User\Factory\Service\AdminServiceFactory',
        'Soflomo\Mail\DefaultTransport' => 'Soflomo\Mail\Factory\DefaultTransportFactory',
        'Soflomo\Mail\DefaultMessage' => 'Soflomo\Mail\Factory\DefaultMessageFactory',
        'Soflomo\Mail\Service\MailService' => 'Soflomo\Mail\Factory\MailServiceFactory',
        'User\Mapper\UserMapper' => 'User\Factory\Mapper\DoctrineORM\UserMapperFactory',
        'User\Mapper\TokenMapper' => 'User\Factory\Mapper\DoctrineORM\TokenMapperFactory',
        'User\Service\DoubleOptInService' => 'User\Factory\Service\DoubleOptInServiceFactory',
        'zfcuser_register_form' => function ($sm) {

            $options = $sm->get('zfcuser_module_options');

            $form = new User\Form\Zfcuser\Register(null, $options);
            //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
            $form->setInputFilter(new User\Form\Zfcuser\RegisterFilter(
                    new ZfcUser\Validator\NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'email'
                    )), new ZfcUser\Validator\NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'username'
                    )), $options
            ));
            return $form;
        },
                'zfcuser_admin_register_form' => function ($sm) {

            $options = $sm->get('zfcuser_module_options');

            $form = new User\Form\Admin\CreateUser(null, $options);
            //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
            $form->setInputFilter(new User\Form\Admin\CreateUserFilter(
                    new ZfcUser\Validator\NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'email'
                    )), new ZfcUser\Validator\NoRecordExists(array(
                'mapper' => $sm->get('zfcuser_user_mapper'),
                'key' => 'username'
                    )), $options
            ));
            return $form;
        },
            ),
        );
        