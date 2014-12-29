<?php
namespace User\Controller;



class UserController extends \ZfcUser\Controller\UserController {

    const ROUTE_CHANGEADRESS = 'change-adress';
    const ROUTE_ACCOUNT = 'index';
  

    protected $changeAdressForm;
    protected $accountForm;
    
    
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
