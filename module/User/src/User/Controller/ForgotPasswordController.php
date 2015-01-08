<?php

namespace User\Controller;

use User\Form\Forgot\ChangePasswordForm;
use User\Form\Forgot\RequestForm;
use User\Service\ ForgotPasswordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;

class ForgotPasswordController extends AbstractActionController
{
    /** @var RequestForm */
    protected $requestForm;

    /** @var ChangePasswordForm */
    protected $changePasswordForm;

    /** @var ForgotPasswordService */
    protected $forgotPasswordService;

    public function __construct(RequestForm $requestForm, ChangePasswordForm $changePasswordForm, ForgotPasswordService $forgotPasswordService)
    {
        $this->requestForm = $requestForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function indexAction()
    {
        $form = $this->requestForm;
        $forgotPasswordService = $this->forgotPasswordService;

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $viewModel->setTemplate('forgot-password/request.phtml');

        $redirectUrl = $this->url()->fromRoute('user/forgot-password');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotPasswordService->request($prg)) {
            $viewModel->setTemplate('forgot-password/confirmation/sent-email.phtml');
            return $viewModel;
        }

        return $viewModel;
    }

    public function changePasswordAction()
    {
        $this->layout('layout/layout');
        $form = $this->changePasswordForm;
        $forgotPasswordService = $this->forgotPasswordService;
        $token = $this->params('token');
        $user = $forgotPasswordService->getUserFromToken($token);

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        if (!$user) {
            
            $this->layout('layout/expired');
            $viewModel->setTemplate('forgot-password/expired.phtml');
            
            return $viewModel;
        }

        $viewModel->setTemplate('forgot-password/change-password.phtml');

        $redirectUrl = $this->url()->fromRoute('user/forgot-password/change-password', ['token' => $token]);
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotPasswordService->changePassword($prg, $user)) {
            $viewModel->setTemplate('forgot-password/confirmation/changed-password.phtml');
            return $viewModel;
        }

        $form->setData([
            'new_password' => null,
            'confirm_new_password' => null,
        ]);

        return $viewModel;
    }
}
