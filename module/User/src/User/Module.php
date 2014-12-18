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



//        $em->attach(
//            'ZfcUser\Form\Register',
//            'init',
//            function($e)
//            {
//                /* @var $form \ZfcUser\Form\Register */
//                $form = $e->getTarget();
//                $form->add(
//                    array(
//                        'name' => 'userrole',
//                        'type' => 'hidden',
//                        'options' => array(
//                            'value' => 'Username',
//                        ),
//                    )
//                );
//            }
//        );

        $em->attach(
                'ZfcUser\Form\Register', 'init', function($e) {
            $form = $e->getTarget();

            $form->remove('username');
            $form->add(array('name' => 'username', 'options' => array('label' => 'Vorname Nachname',),
                'attributes' => array('type' => 'text',),
                    )
            );
            $form->remove('email');
            $form->add(array('name' => 'email', 'options' => array('label' => 'Email',),
                'attributes' => array('type' => 'text',),
                    )
            );
            $form->remove('password');
            $form->add(array(
                'name' => 'password','options' => array( 'label' => 'Passwort', ),
                'attributes' => array('type' => 'password' ),
            ));
            $form->remove('passwordVerify');
            $form->add(array('name' => 'passwordVerify','options' => array('label' => 'Password Verify',),'attributes' => array('type' => 'password'
                ),
            ));

            $form->remove('display_name');
            $form->add(array('name' => 'display_name', 'options' => array('label' => 'Nutzername',),
                'attributes' => array('type' => 'text',),
                    )
            );

            $form->add(array('name' => 'street', 'options' => array('label' => 'Strasse',),
                'attributes' => array('type' => 'text',),
                    )
            );

            $form->add(
                    array('name' => 'plz', 'options' => array('label' => 'Postleitzahlen',),
                        'attributes' => array('type' => 'text',),
                    )
            );
            $form->add(
                    array('name' => 'village', 'options' => array('label' => 'Ort',),
                        'attributes' => array('type' => 'text',),
                    )
            );
        }
        );

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

}
