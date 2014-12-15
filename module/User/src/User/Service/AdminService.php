<?php

namespace User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use User\Form\Forgot\ChangePasswordForm;
use User\Form\Forgot\RequestForm;
use User\Mapper\TokenMapperInterface;
use User\Mapper\UserMapperInterface;
use User\Entity\TokenInterface;
use ZfcUser\Entity\UserInterface;

class AdminService {

    /** @var listForm */
    protected $listForm;

    /** @var UserMapperInterface */
    protected $userMapper;

    public function __construct(\User\Form\Admin\ListForm $listForm, UserMapperInterface $userMapper) {
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

        $this->userMapper->findAll();
   
        
    }
}
