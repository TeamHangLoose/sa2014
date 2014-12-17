<?php

namespace User\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author sommer
 */
class UserController extends \ZfcUser\Controller\UserController {

    const ROUTE_CHANGEADRESS = 'change-adress';

    protected $changeAdressForm;

       public function uploadAction()
    {
       // if the user isn't logged in, we can't change Adress
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
      // redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->notFoundAction();
        }
        
        $options = $this->getOptions();
        $form = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');
     
        $request = $this->getRequest();
        $imageUploaded = false;
        if ($request->isPost()) {
            $negotiator   = new FormatNegotiator();
            $format = $negotiator->getBest(
                $request->getHeader('Accept')->getFieldValue(),
                ['application/json', 'text/html']
            );
            if ($this->profileImageService->storeImage($user, $request->getFiles()->toArray())) {
                if ($format->getValue() === 'application/json') {
                    return new Model\JsonModel([
                        'uploaded' => true
                    ]);
                } elseif ($options->getPostUploadRoute()) {
                        return call_user_func_array([$this->redirect(), 'toRoute'], (array) $options->getPostUploadRoute());
                }
                $imageUploaded = true;
            } else {
                $response = $this->getResponse();
            
                $response->setStatusCode(400);
                if ($format->getValue() === 'application/json') {
                    return new Model\JsonModel([
                        'error' => true,
                        'messages' => $form->getMessages()
                    ]);
                }

            }
        }
        

        return new Model\ViewModel([
            'form' => $form,
            'imageUploaded' => $imageUploaded,
            'user' => $user
        ]);
    }


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
    
    
      protected function getUser()
    {
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
