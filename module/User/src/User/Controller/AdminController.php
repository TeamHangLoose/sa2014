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

    public function listAction() {

        // $userMapper = $this->getUserMapper();
        $users = $this->adminService->listUser();

        //$paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($users));
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($users));

        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));


        return array(
            'users' => $paginator,
            'userlistElements' => $this->moduleOptions->getUserListElements()
        );
    }

    public function createAction() {
   
    }

    public function editAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');

        $user = $this->getUserMapper()->findById($userId);

        /** @var $form \ZfcUserAdmin\Form\EditUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_edituser_form');
        $form->setUser($user);

        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $this->getAdminUserService()->edit($form, (array) $request->getPost(), $user);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was edited');
                    return $this->redirect()->toRoute('admin/list');
                }
            }
        } else {
            $form->populateFromUser($user);
        }

        return array(
            'editUserForm' => $form,
            'userId' => $userId
        );
    }

}
