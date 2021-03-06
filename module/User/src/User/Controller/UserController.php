<?php

namespace User\Controller;

/*
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */

use Zend\View\Model\ViewModel;
use Zend\Stdlib\Parameters;

/**
 * Description of UserController
 * UserController handel the User section
 * extends zfcUserController
 * overwritten functions are index/login/logout/register 
 * @author abbts2015 B14.if4.1 G.3
 */
class UserController extends \ZfcUser\Controller\UserController {

    const ROUTE_CHANGEADRESS = 'change-adress';
    const ROUTE_ACCOUNT = 'index';
    const ROUTE_OPTIN = 'double-opt-in';

    /** @var changeAdressForm changeAdressForm */
    protected $changeAdressForm;

    /**
     * Index
     * @return ViewModel
     */
    public function indexAction() {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        $imageService = $this->getServiceLocator()->get('HtProfileImage\Service\ProfileImageService');
        if ($imageService->userImageExists($this->getUser())) {
            $imageService->getUserImage($this->getUser(), $filterAlias = null);
        }
        return new ViewModel();
    }

    /**
     * Login form
     */
    public function loginAction() {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
        $request = $this->getRequest();
        $form = $this->getLoginForm();
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        if (!$request->isPost()) {
            return array(
                'loginForm' => $form,
                'redirect' => $redirect,
                'enableRegistration' => $this->getOptions()->getEnableRegistration(),
            );
        }
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            $this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
        }
        if (!$this->getUserService()->isActive($form->getData())) {

            $this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
        }
        // clear adapters
        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();
        return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
    }

    /**
     * Logout and clear the identity and Temp Files
     */
    public function logoutAction() {
        $imageService = $this->getServiceLocator()->get('HtProfileImage\Service\ProfileImageService');
        $imageService->logoutDeleteCache($this->getUser());
        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthAdapter()->logoutAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();
        $redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        }
        return $this->redirect()->toRoute($this->getOptions()->getLogoutRedirectRoute());
    }

    /**
     * Register new user
     */
    public function registerAction() {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
        if (!$this->getOptions()->getEnableRegistration()) {
            return array('enableRegistration' => false);
        }
        $request = $this->getRequest();
        $service = $this->getUserService();
        $form = $this->getRegisterForm();
        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        $redirectUrl = $this->url()->fromRoute(static::ROUTE_REGISTER)
                . ($redirect ? '?redirect=' . rawurlencode($redirect) : '');
        $prg = $this->prg($redirectUrl, true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'registerForm' => $form,
                'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );
        }
        $post = (array) $prg;
        $user = $service->register($post);
        if ($user && !$service->getOptions()->getLoginAfterRegistration()) {

            $post['email'] = $user->getEmail();
            $request->setPost(new Parameters($post));
            return $this->forward()->dispatch('User\Controller\DoubleOptIn', array('action' => 'index'));
        }
        $redirect = isset($post['redirect']) ? $post['redirect'] : null;
        if (!$user) {
            return array(
                'registerForm' => $form,
                'enableRegistration' => $this->getOptions()->getEnableRegistration(),
                'redirect' => $redirect,
            );
        }
        if ($service->getOptions()->getLoginAfterRegistration()) {
            $identityFields = $service->getOptions()->getAuthIdentityFields();
            if (in_array('email', $identityFields)) {
                $post['identity'] = $user->getEmail();
            } elseif (in_array('username', $identityFields)) {
                $post['identity'] = $user->getUsername();
            }
            $post['credential'] = $post['password'];
            $request->setPost(new Parameters($post));
            return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
        }
        return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
    }

    /**
     * Change User Adress
     */
    public function changeadressAction() {
        // if the user isn't logged in, we can't change Adress
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
        $form = $this->getChangeAdressForm();
        $prg = $this->prg(static::ROUTE_CHANGEADRESS);
        $fm = $this->flashMessenger()->setNamespace('change-adress')->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'status' => $status,
                'changeAdressForm' => $form,
            );
        }
        $form->setData($prg);
        if (!$form->isValid()) {
            return array(
                'status' => false,
                'changeAdressForm' => $form,
            );
        }
        if (!$this->getUserService()->changeAdress($form->getData())) {
            return array(
                'status' => false,
                'changeAdressForm' => $form,
            );
        }
        $this->flashMessenger()->setNamespace('change-adress')->addMessage(true);
        return $this->redirect()->toRoute(static::ROUTE_CHANGEADRESS);
    }

    function setChangeAdressForm($changeAdressForm) {
        $this->changeAdressForm = $changeAdressForm;
    }

    /**
     * get ChangeAdressForm
     * @return Form
     */
    public function getChangeAdressForm() {
        if (!$this->changeAdressForm) {
            $options = $this->getServiceLocator()->get('zfcuser_module_options');
            $form = new \User\Form\User\ChangeAdress(null, $this->getServiceLocator()->get('zfcuser_module_options'));
            $form->setInputFilter(new \User\Form\User\ChangeAdressFilter($options));
            $this->setChangeAdressForm($form);
        }
        return $this->changeAdressForm;
    }

    /**
     * get User
     */
    protected function getUser() {
        $authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        /** @var \ZfcUser\Entity\UserInterface $user */
        $user = $authenticationService->getIdentity();
        $userId = $this->params()->fromRoute('userId', null);
        if ($userId !== null) {
            $currentUser = $user;
            $user = $this->getUserMapper()->findById($userId);
            if (!$user) {
                return null;
            }
            if (!$this->getOptions()->getEnableInterUserImageUpload() && ($user->getId() !== $currentUser->getId())) {
                return null;
            }
        }
        return $user;
    }

}
