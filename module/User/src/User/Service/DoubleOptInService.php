<?php
namespace User\Service;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Form\DoubleOptIn\Confirmed;
use User\Mapper\TokenMapperInterface;
use User\Mapper\UserMapperInterface;
use ZfcUser\Entity\UserInterface;
use Zend\Crypt\Password\Bcrypt;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DoubleOptInService
 * Double opt in
 */
class DoubleOptInService {

    /** @var ChangePasswordForm */
    protected $confirmedForm;

    /** @var UserMapperInterface */
    protected $userMapper;

    /** @var TokenMapperInterface */
    protected $tokenMapper;

    /** @var MailService */
    protected $mailService;
    protected $options;

    public function __construct(Confirmed $confirmedForm, UserMapperInterface $userMapper, TokenMapperInterface $tokenMapper, MailService $mailService, \ZfcUser\Options\ModuleOptions $zfcUserOptions) {
        $this->confirmedForm = $confirmedForm;
        $this->userMapper = $userMapper;
        $this->tokenMapper = $tokenMapper;
        $this->mailService = $mailService;
        $this->options = $zfcUserOptions;
    }

    public function request($email) {
        $user = $this->userMapper->findByEmail($email);

        if (!$user) {
            return false;
        }
        $token = $this->tokenMapper->generate($user);

        $options = [
            'from' => 'Badenfahrt2014@gmail.com',
            'from_name' => 'Badenfahrt',
            'to' => $user->getEmail(),
            'subject' => 'Confirm your email',
            'template' => 'email/optin-confirmation'
        ];

        $this->mailService->sendToken($token, $user, $options);

        return true;
    }

    function getConfirmedForm() {
        return $this->confirmedForm;
    }

    /**
     * Change password for user
     *
     * @param array $data
     * @param UserInterface $user
     * @return bool
     */
    public function confirmed(array $data, UserInterface $user) {

        $token = $this->tokenMapper->findByUser($user);
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->options->getPasswordCost());

        if ($bcrypt->verify($data['cred'], $user->getPassword())) {
            $this->userMapper->setActive($user);
            $this->tokenMapper->remove($token);

            return true;
        }

        return false;
    }

    /**
     * Get identity from token
     *
     * @param string $token
     * @return bool|UserInterface
     */
    public function getUserFromToken($token) {
        $entity = $this->tokenMapper->findByToken($token);

        if (!$entity) {
            return false;
        }

        return $this->userMapper->findById($entity->getUser());
    }
    
    
     public function userIsActice(){
        return true;
    } 
    

}
