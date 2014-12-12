<?php

return [
    'aliases' => [
        'objectManager' => 'Doctrine\ORM\EntityManager',
        'Soflomo\Mail\Renderer' => 'ViewRenderer',
        'Soflomo\Mail\Transport' => 'Soflomo\Mail\DefaultTransport',
        'Soflomo\Mail\Message' => 'Soflomo\Mail\DefaultMessage',
    ],
    'invokables' => [
        'User\Form\Forgot\RequestForm' => 'User\Form\Forgot\RequestForm',
        'User\Form\Forgot\ChangePasswordForm' => 'User\Form\Forgot\ChangePasswordForm',
    ],
    'initializers' => [
        'mail_transport' => 'Soflomo\Mail\Service\TransportAwareInitializer',
        'mail_message' => 'Soflomo\Mail\Service\MessageAwareInitializer',
    ],
    'shared' => [
        'Soflomo\Mail\DefaultMessage' => false,
    ],
    'factories' => [
        'User\Service\ForgotPasswordService' => 'User\Factory\Service\ForgotPasswordServiceFactory',
        'User\Service\MailService' => 'User\Factory\Service\MailServiceFactory',
        'User\Options\ModuleOptions' => 'User\Factory\Options\ModuleOptionsFactory',
        'Soflomo\Mail\DefaultTransport' => 'Soflomo\Mail\Factory\DefaultTransportFactory',
        'Soflomo\Mail\DefaultMessage' => 'Soflomo\Mail\Factory\DefaultMessageFactory',
        'Soflomo\Mail\Service\MailService' => 'Soflomo\Mail\Factory\MailServiceFactory',
        'User\Mapper\UserMapper' => 'User\Factory\Mapper\DoctrineORM\UserMapperFactory',
        'User\Mapper\TokenMapper' => 'User\Factory\Mapper\DoctrineORM\TokenMapperFactory',
    ]
];
