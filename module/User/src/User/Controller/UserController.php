<?php

namespace User\Controller;

class UserController extends \ZfcUser\Controller\UserController {

    const ROUTE_CHANGEADRESS = 'change-adress';
    const ROUTE_ACCOUNT = 'index';

    protected $changeAdressForm;
    protected $accountForm;

    /**
     * Register new user
     */
    public function registerAction() {
        // if the user is logged in, we don't need to register
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
        // if registration is disabled
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

        $post = $prg;
        $user = $service->register($post);

        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

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

        
        /*
         * Send Confirmation Email. 
         * 
         */
        
        
        // TODO: Add the redirect parameter here...
        return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN) . ($redirect ? '?redirect=' . rawurlencode($redirect) : ''));
    }

    /*
      public function uploadFormAction() {
      $form = new \User\Form\User\UploadForm('upload-form');
      $request = $this->getRequest();
      if ($request->isPost()) {
      // Make certain to merge the files info!
      $post = array_merge_recursive(
      $request->getPost()->toArray(), $request->getFiles()->toArray()
      );

      $form->setData($post);
      if ($form->isValid()) {
      $data = $form->getData();
      // Form is valid, save the form!
      if (!empty($post['isAjax'])) {
      return new JsonModel(array(
      'status' => true,
      'redirect' => $this->url()->fromRoute('upload-form/success'),
      'formData' => $data,
      ));
      } else {
      // Fallback for non-JS clients
      return $this->redirect()->toRoute('upload-form/success');
      }
      } else {
      if (!empty($post['isAjax'])) {
      // Send back failure information via JSON
      return new JsonModel(array(
      'status' => false,
      'formErrors' => $form->getMessages(),
      'formData' => $form->getData(),
      ));
      }
      }
      }

      return array('form' => $form);
      }

      public function uploadProgressAction() {
      $id = $this->params()->fromQuery('id', null);
      $progress = new \Zend\ProgressBar\Upload\SessionProgress();
      return new \Zend\View\Model\JsonModel($progress->getProgress($id));
      }
     * /
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

    public function getChangeAdressForm() {
        if (!$this->changeAdressForm) {

            $options = $this->getServiceLocator()->get('zfcuser_module_options');
            $form = new \User\Form\User\ChangeAdress(null, $this->getServiceLocator()->get('zfcuser_module_options'));
            $form->setInputFilter(new \User\Form\User\ChangeAdressFilter($options));
            $this->setChangeAdressForm($form);
        }
        return $this->changeAdressForm;
    }

    function setAccountForm($AccountForm) {
        $this->accountForm = $AccountForm;
    }

    public function getAccountForm() {
        if (!$this->accountForm) {
            $options = $this->getServiceLocator()->get('zfcuser_module_options');
            $form = new \User\Form\User\Account(null, $this->getServiceLocator()->get('zfcuser_module_options'));
            $form->setInputFilter(new \User\Form\User\AccountFilter($options));
            $this->setChangeAdressForm($form);
        }
        return $this->accountForm;
    }

}
