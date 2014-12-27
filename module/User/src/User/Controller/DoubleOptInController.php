<?php
namespace User\Controller;


use User\Form\Forgot\ChangePasswordForm;
use User\Form\Forgot\RequestForm;
use User\Service\DoubleOptInService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;

class DoubleOptInController extends AbstractActionController{

    /** @var ChangePasswordForm */
    protected $confirmedForm;

    /** @var ForgotPasswordService */
    protected $forgotPasswordService;

    public function __construct(User\Form\DoubleOptIn\RequestForm $requestForm,\User\Form\DoubleOptIn\Confirmed $confirmedForm, DoubleOptInService $doubleOptInService)
    {
        $this->requestForm = $requestForm;
        $this->confirmedForm = $confirmedForm;
        $this->doubleOptInService = $doubleOptInService;
    }
    
    
    
      public function indexAction()
    {
        $form = $this->requestForm;
        $forgotPasswordService = $this->forgotPasswordService;

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $viewModel->setTemplate('double-opt-in/sent-email.phtml');

        $redirectUrl = $this->url()->fromRoute('user/double-opt-in');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotPasswordService->request($prg)) {
            $viewModel->setTemplate('double-opt-in/confirmation/sent-email.phtml');
            return $viewModel;
        }

        return $viewModel;
    }

    public function changePasswordAction()
    {
        $form = $this->changePasswordForm;
        $forgotPasswordService = $this->forgotPasswordService;
        $token = $this->params('token');
        $user = $forgotPasswordService->getUserFromToken($token);

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        if (!$user) {
            $viewModel->setTemplate('zfc-user-forgot-password/expired.phtml');
            return $viewModel;
        }

        $viewModel->setTemplate('zfc-user-forgot-password/change-password.phtml');

        $redirectUrl = $this->url()->fromRoute('user/zfc-user-forgot-password/change-password', ['token' => $token]);
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($forgotPasswordService->changePassword($prg, $user)) {
            $viewModel->setTemplate('zfc-user-forgot-password/confirmation/changed-password.phtml');
            return $viewModel;
        }

        $form->setData([
            'new_password' => null,
            'confirm_new_password' => null,
        ]);

        return $viewModel;
    }
    
    
    

}
