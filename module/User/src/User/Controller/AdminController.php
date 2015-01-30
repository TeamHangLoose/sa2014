<?php

namespace User\Controller;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\Admin\ListForm;
use Zend\Stdlib\Hydrator\ClassMethods;
use User\Service\AdminService;
use User\Options\ModuleOptions;
use Zend\Paginator\Paginator;
use User\Form\Admin\EditUser;

/**
 * Description of AdminController
 * AdminController handel the Andim section
 *  User function are edit/remove/list/delete
 * @author abbts2015 B14.if4.1 G.3
 */
class AdminController extends AbstractActionController {

    /** @var \User\Options\ModuleOptions */
    protected $moduleOptions;

    /** @var \User\Form\Admin\ListForm */
    protected $listForm;

    /** @var \User\Service\AdminService */
    protected $adminService;

    /** @var \User\Form\Admin\CreateUserForm */
    protected $creatUserForm;

    /** @var \ZfcUser\Options\ModuleOptions */
    protected $zfcUserOptions;

    /**
     * Constructor
     * @param ListForm $listForm
     * @param AdminService $adminService
     * @param ModuleOptions $moduleOptions
     * @param \ZfcUser\Options\ModuleOptions $zfcUserOptions
     */
    public function __construct(ListForm $listForm, AdminService $adminService, ModuleOptions $moduleOptions, \ZfcUser\Options\ModuleOptions $zfcUserOptions) {
        $this->listForm = $listForm;
        $this->adminService = $adminService;
        $this->moduleOptions = $moduleOptions;
        $this->zfcUserOptions = $zfcUserOptions;
    }

    /**
     * list
     * @return array
     */
    public function listAction() {
        $users = $this->adminService->listUser();
        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($users));
        $paginator->setItemCountPerPage($this->moduleOptions->getNumberOfListLines());
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));
        return array(
            'users' => $paginator,
            'userlistElements' => $this->moduleOptions->getUserListElements()
        );
    }

    /**
     * create
     * @return redirect toRoute('admin/list')
     * @return Form
     */
    public function createAction() {
        $form = $this->getCreatUserForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
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

    /**
     * edit
     * @return redirect toRoute('admin/list')
     * @return Form
     */
    public function editAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->adminService->getUserByID($userId);
        /** @var $form \ZfcUserAdmin\Form\EditUser */
        $form = new EditUser(null, $this->moduleOptions, $this->zfcUserOptions, $this->getServiceLocator());
        $form->setUser($user);
        $roles = $user->getRoles();

        foreach ($roles as $key => $value) {
            $roleId = $value->getRoleId();
            $role = $value->getId();
        }
        /* @var $role def user role */
        if (!$role) {
            $role = 1;
        }
        $form->get('role')->setValue($role);
        /*
          /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $this->adminService->edit($form, (array) $request->getPost(), $user, $this->moduleOptions, $this->zfcUserOptions);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('User wurde geändert');
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

    /**
     * remove
     * @return redirect toRoute('admin/list')
     */
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

    function getCreatUserForm() {
        if (!$this->creatUserForm) {
            $this->setCreatUserForm($this->getServiceLocator()->get('zfcuser_admin_register_form'));
        }
        return $this->creatUserForm;
    }

    function setCreatUserForm($creatUserForm) {
        $this->creatUserForm = $creatUserForm;
    }

    public function setRegisterForm(Form $registerForm) {
        $this->registerForm = $registerForm;
    }

}
