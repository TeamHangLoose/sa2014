<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController {

       /** @var RequestForm */
    protected $listForm;

    /** @var ForgotPasswordService */
    protected $adminService;

    public function __construct(\User\Form\Admin\ListForm $listForm, \User\Service\AdminService $adminService)
    {
        $this->listForm = $listForm;
        $this->adminService = $adminService;
    }
    
    
    public function indexAction() {

         $form = $this->listForm;
         $adminService = $this->adminService;

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
              
        if ($adminService->listUser()) {
           // $viewModel->setTemplate('admin/list.phtml');
            return $viewModel;
        }

        return $viewModel;
    }

}
