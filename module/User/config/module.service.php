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
        'zfcuser_user_service' => 'User\Service\User',
        
       
        'User\Form\ZfcUser\Register' => 'User\Form\ZfcUser\Register',
        'User\Form\User\Index' => 'User\Form\User\Index',
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
        
        )
);
