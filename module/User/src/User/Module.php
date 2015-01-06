<?php

namespace User;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap($e) {

        //adding costum fields to register form
        $eventManager = $e->getApplication()->getEventManager();
        $em = $eventManager->getSharedManager();


        $em->attach('HtProfileImage\Service\ProfileImageService', 'storeImage', function ($event) {
            $user = $event->getParam('user');
            
            // Now, check if the identity has access to this user
        });
        //include 'Form/Zfcuser/register_ext.php';
        include 'Form/Zfcuser/changeEmail_ext.php';

        include 'Form/Zfcuser/changepassword_ext.php';


        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();

        $orm = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');

        $zfcServiceEvents->attach('register', function($e) use ($orm) {
            //standard Role for all new Users -> user
            $userRole = $orm->getRepository('User\Entity\Role')->find(2);
            $user = $e->getParam('user');
            /* @var $user \User\Entity\User */
            $user->getRoles()->add($userRole);
        });

        // you can even do stuff after it stores
//        $zfcServiceEvents->attach('register.post', function($e) {
//            /*$user = $e->getParam('user');*/
//        });
    }

    public function getServiceConfig() {



        return include __DIR__ . '../../../config/module.service.php';
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'AccountDisplay' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new \User\View\Helper\AccountDisplay;
                    $viewHelper->setAuthService($locator->get('zfcuser_auth_service'));
                    return $viewHelper;
                },
            ),
        );
    }

}
