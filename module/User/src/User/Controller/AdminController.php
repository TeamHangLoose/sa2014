<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;

class AdminController extends AbstractActionController {

    /**
     * @var \User\Options\ModuleOptions
     */
    protected $moduleOptions;

    /** @var RequestForm */
    protected $listForm;

    /** @var ForgotPasswordService */
    protected $adminService;

    public function __construct(\User\Form\Admin\ListForm $listForm, \User\Service\AdminService $adminService, \User\Options\ModuleOptions $moduleOptions) {
        $this->listForm = $listForm;
        $this->adminService = $adminService;
        $this->moduleOptions = $moduleOptions;
    }

    public function indexAction() {

        // $userMapper = $this->getUserMapper();
        $users = $this->adminService->listUser();

        //$paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($users));
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($users));

        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));
   
        
        return array(
            'users' => $paginator,
            'userlistElements' => $this->moduleOptions->getUserListElements()
        );

        /*
          $form = $this->listForm;
          $adminService = $this->adminService;


          $viewModel = new ViewModel([
          'form' => $form,
          ]);




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
         * 
         * 
         */
    }

}
