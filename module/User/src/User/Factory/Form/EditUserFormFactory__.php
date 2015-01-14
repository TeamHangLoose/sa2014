<?php
namespace User\Factory\Form;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateUserFormFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {

        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');

        $zfcModuleOptions = $serviceLocator->get('zfcuser_module_options');
        $filter = new RegisterFilter(
                new NoRecordExists(array(
            'mapper' => $serviceLocator->get('zfcuser_user_mapper'),
            'key' => 'email'
                )), new NoRecordExists(array(
            'mapper' => $serviceLocator->get('zfcuser_user_mapper'),
            'key' => 'username'
                )), $moduleOptions
        );
        if ($moduleOptions->getCreateUserAutoPassword()) {
            $filter->remove('password')->remove('passwordVerify');
        }
        $form = new \User\Form\Admin\CreateUser(null, $moduleOptions, $zfcModuleOptions, $serviceLocator);
        $form->setInputFilter($filter);
        return $form;
    }

//put your code here
}
