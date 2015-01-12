<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',            
            'zfcuser'=> 'User\Controller\UserController',
   


        ),
        'factories' => array(
            'User\Controller\ForgotPassword' => 'User\Factory\Controller\ForgotPasswordControllerFactory',
            'User\Controller\Admin' => 'User\Factory\Controller\AdminControllerFactory',
            'User\Controller\DoubleOptIn' => 'User\Factory\Controller\DoubleOptInControllerFactory',
           
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/User/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'User\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    //We have edited the view scripts so we must say to zfcuser that these are our new view scripts
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/expired' => __DIR__ . '/../view/layout/expired.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'zfc-user/user/index' => __DIR__ . '/../view/zfc-user/user/index.phtml'
        ),
        'template_path_stack' => array(
            'zfcuser' => __DIR__ . '/../view',
            'HtProfileImage' => __DIR__ . '/../view',
        ),
    ),
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class' => 'User\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        
    ),
    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'default_role' => 'guest',
        'role_providers' => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager' => 'doctrine.entity_manager.orm_default',
                'role_entity_class' => 'User\Entity\Role',
            ),
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'menu' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    /*
                      [0] -> role
                      [1] -> resource
                      [2] -> rule
                     */
                    array(array('admin'), 'menu', array('menu_admin')),
                    array(array('user'), 'menu', array('menu_user')),
                ),
            ),
        ),
        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcuser', 'roles' => array('user')),
                array('route' => 'zfcuser/logout', 'roles' => array('user')),
                array('route' => 'zfcuser/login', 'roles' => array('guest')),
                array('route' => 'zfcuser/register', 'roles' => array('guest')),
               
                array('route' => 'user/forgot-password', 'roles' => array('guest')),
                
                array('route' => 'user/change-password', 'roles' => array('guest')),
                array('route' => 'user/forgot-password', 'roles' => array('guest')),
                
                array('route' => 'admin/list', 'roles' => array('admin')),
                
                array('route' => 'admin/create', 'roles' => array('admin')),
                array('route' => 'admin/remove', 'roles' => array('admin')),
                array('route' => 'admin/edit', 'roles' => array('admin')),
                
                array('route' => 'user/forgot-password/change-password', 'roles' => array('guest')),
                
                array('route' => 'double-opt-in/confirmed', 'roles' => array('guest')),
                array('route' => 'double-opt-in', 'roles' => array('guest')),
               
                array('route' => 'zfcuser/changeemail', 'roles' => array('user')),
                array('route' => 'change-adress', 'roles' => array('user')),
                array('route' => 'zfcuser/changepassword', 'roles' => array('user')),
                // Below is the default index action used by the ZendSkeletonApplication
                array('route' => 'home', 'roles' => array('guest', 'user')),
                
                
                array('route' => 'zfcuser/htimageupload', 'roles' => array('user')),
                array('route' => 'zfcuser/htimagedisplay', 'roles' => array('user')),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'change-adress' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user/change-adress',
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action' => 'changeadress',
                    ),
                ),
            ),
            'double-opt-in' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/opt-in',
                    'defaults' => array(
                        'controller' => 'User\Controller\DoubleOptIn',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'confirmed' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/confirmed/:token',
                            'defaults' => array(
                                'controller' => 'User\Controller\DoubleOptIn',
                                'action' => 'confirmed',
                            ),
                        ),
                    ),
                ),
            ),
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'forgot-password' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => 'forgot-password',
                            'defaults' => array(
                                'controller' => 'User\Controller\ForgotPassword',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'change-password' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route' => '/change-password/:token',
                                    'defaults' => array(
                                        'controller' => 'User\Controller\ForgotPassword',
                                        'action' => 'changePassword',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin'
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/list/[:p]',
                            'defaults' => array(
                                'controller' => 'User\Controller\Admin',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'User\Controller\Admin',
                                'action' => 'create'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:userId',
                            'defaults' => array(
                                'controller' => 'User\Controller\Admin',
                                'action' => 'edit',
                                'userId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:userId',
                            'defaults' => array(
                                'controller' => 'User\Controller\Admin',
                                'action' => 'remove',
                                'userId' => 0
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'soflomo_mail' => array(
        'message' => array(
            'encoding' => 'UTF-8',
        ),
        'transport' => array(
            'type' => null,
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'email' => 'Soflomo\Mail\Factory\EmailControllerPluginFactory',
        ),
    ),
    'htimg' => array(
        'filters' => array(
            'htprofileimage_store' => array(
                'type' => 'thumbnail',
                'options' => array(
                    'width' => 220,
                    'height' => 220,
                    'mode' => 'outbound '
                ),
            ),
            'htprofileimage_display' => array(
                'type' => 'thumbnail',
                'options' => array(
                    'width' => 200,
                    'height' => 200,
                    'mode' => 'outbound ',
                ),
            ),
        ),
    ),
);
