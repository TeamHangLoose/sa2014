<?php

namespace User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use User\Form\Forgot\ChangePasswordForm;
use User\Form\Forgot\RequestForm;
use User\Mapper\TokenMapperInterface;
use User\Mapper\UserMapperInterface;
use User\Entity\TokenInterface;
use ZfcUser\Entity\UserInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DoubleOptInService
 *
 * @author win7
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

    public function __construct(\User\Form\DoubleOptIn\ConfirmedForm $confirmedForm,UserMapperInterface $userMapper, TokenMapperInterface $tokenMapper, MailService $mailService
    ) {
        $this->confirmedForm = $confirmedForm;
        $this->userMapper = $userMapper;
        $this->tokenMapper = $tokenMapper;
        $this->mailService = $mailService;
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
            'subject' => 'Forgot password test',
            'template' => 'email/optin-confirmation'
        ];

        $this->mailService->sendToken($token, $user, $options);

        return true;
    }

}
