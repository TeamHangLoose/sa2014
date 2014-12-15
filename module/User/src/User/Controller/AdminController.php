<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController {

       /** @var RequestForm */
    protected $listForm;

    /** @var ForgotPasswordService */
    protected $listService;

    public function __construct(RequestForm $requestForm, ChangePasswordForm $changePasswordForm, ForgotPasswordService $forgotPasswordService)
    {
        $this->listForm = $requestForm;
        $this->listService = $forgotPasswordService;
    }
    
    
    public function indexAction() {

         $form = $this->listForm;
         $forgotPasswordService = $this->listService;

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $viewModel->setTemplate('admin/list.phtml');

        $redirectUrl = $this->url()->fromRoute('zfcuser/login');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }


        return $viewModel;
    }

}
