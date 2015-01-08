<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;

class AdminController extends AbstractActionController {

    /**
     * @var \User\Options\ModuleOptions
     */
    protected $moduleOptions;

    /** @var RequestForm */
    protected $listForm;

    /** @var ForgotPasswordService */
    protected $adminService;
    protected $zfcUserOptions;

    public function __construct(\User\Form\Admin\ListForm $listForm, \User\Service\AdminService $adminService, \User\Options\ModuleOptions $moduleOptions, \ZfcUser\Options\ModuleOptions $zfcUserOptions) {
        $this->listForm = $listForm;
        $this->adminService = $adminService;
        $this->moduleOptions = $moduleOptions;
        $this->zfcUserOptions = $zfcUserOptions;
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

        //$form = $this->getServiceLocator()->get('admin_createuser_form');

        $form = new \User\Form\Admin\CreateUser(null, $this->moduleOptions, $this->zfcUserOptions, $this->getServiceLocator());

        $request = $this->getRequest();

        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {
            //$zfcUserOptions = $this->zfcUserOptions;
            $class = $this->zfcUserOptions->getUserEntityClass();
            $user = new $class();
            $form->setHydrator(new ClassMethods());
            $form->bind($user);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user = $this->adminService->create($form, (array) $request->getPost(), $this->zfcUserOptions, $this->moduleOptions);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was created');
                    return $this->redirect()->toRoute('admin/list');
                }
            }
        }

        return array(
            'createUserForm' => $form
        );
    }

    public function editAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');

        $user = $this->adminService->getUserByID($userId);

        /** @var $form \ZfcUserAdmin\Form\EditUser */
        $form = new \User\Form\Admin\EditUser(null, $this->moduleOptions, $this->zfcUserOptions, $this->getServiceLocator());

        $form->setUser($user);

        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $this->adminService->edit($form, (array) $request->getPost(), $user,$this->moduleOptions,$this->zfcUserOptions);
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

    public function removeAction() {
        
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');

        /** @var $identity \ZfcUser\Entity\UserInterface */
        $identity = $this->zfcUserAuthentication()->getIdentity();
        
        if ($identity && $identity->getId() == $userId) {
            $this->flashMessenger()->addErrorMessage('You can not delete yourself');
        } else {
            $user = $this->adminService->getUserByID($userId);
            if ($user) {
                $this->adminService->remove($user);
                $this->flashMessenger()->addSuccessMessage('The user was deleted');
            }
        }

        return $this->redirect()->toRoute('admin/list');
    }

}
