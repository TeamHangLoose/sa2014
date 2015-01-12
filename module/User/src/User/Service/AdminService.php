<?php

namespace User\Service;

use User\Mapper\UserMapperInterface;
use Zend\Form\Form;
use Zend\Math\Rand;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class AdminService extends EventProvider implements ServiceManagerAwareInterface {

    /** @var listForm */
    protected $listForm;

    /** @var UserMapperInterface */
    protected $userMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(\User\Form\Admin\ListForm $listForm, \User\Mapper\DoctrineORM\UserMapper $userMapper) {
        $this->listForm = $listForm;
        $this->userMapper = $userMapper;
    }

    /**
     * Request new password
     *
     * @param array $data
     * @return bool
     */
    public function listUser() {
        $users = $this->userMapper->findAll();
        return $users;
    }

    public function getUserByID($id) {
        $user = $this->userMapper->findById($id);
        return $user;
    }
    
     public function remove($user) {
        $user = $this->userMapper->remove($user);
        return $user;
    }

    public function edit(Form $form, array $data, \User\Entity\User $user,$modulOptions,$zfcUserOptions) {
        // first, process all form fields

        foreach ($data as $key => $value) {
            if ($key == 'password')
                continue;
        
            $setter = $this->getAccessorName($key);
            if (method_exists($user, $setter))
                call_user_func(array($user, $setter), $value);
        }
     
        $argv = array();
        // then check if admin wants to change user password
        if ($modulOptions->getAllowPasswordChange()) {
            if (!empty($data['reset_password'])) {
                $argv['password'] = $this->generatePassword();
            } elseif (!empty($data['password'])) {
                $argv['password'] = $data['password'];
            }

            if (!empty($argv['password'])) {
                $bcrypt = new Bcrypt();
                $bcrypt->setCost($zfcUserOptions->getPasswordCost());
                $user->setPassword($bcrypt->create($argv['password']));
            }
        }

        // TODO: not sure if this code is required here - all fields that came from the form already saved
        foreach ($modulOptions->getEditFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }

        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->userMapper->save($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }

    public function create(Form $form, array $data, $zfcUserOptions, $modulOptions) {

        //$zfcUserOptions = $this->getZfcUserOptions();
     
        $user = $form->getData();
        $formdata =$form->getData();
        $argv = array();
        /*
        $x='';
        foreach ($data as $key => $value){
            
            $x=$x.' '.$key.' '.$value.'<br>';
        }
        echo $x;
       
        $role = new \User\Entity\Role();
        $role->setId($user->getId());
        $role->setRoleId($data['role']);
        $user->addRole($role); 
        */
 /*
          $orm = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
          $userRole = $orm->getRepository('User\Entity\Role')->find(2);
            $user = $e->getParam('user');
            // @var $user \User\Entity\User 
            $user->getRoles()->add($userRole);
       */
        $role = $this->userMapper->getRole(2);
        $user->addRole($role); 
        if ($modulOptions->getCreateUserAutoPassword()) {
            $argv['password'] = $this->generatePassword($modulOptions);
        } else {
            $argv['password'] = $user->getPassword();
        }
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($zfcUserOptions->getPasswordCost());
        $user->setPassword($bcrypt->create($argv['password']));

        foreach ($modulOptions->getCreateFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }

        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->userMapper->save($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * @return string
     */
    public function generatePassword($modulOptions) {
        return Rand::getString($modulOptions->getAutoPasswordLength());
    }

       protected function getAccessorName($property, $set = true)
    {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }
}
