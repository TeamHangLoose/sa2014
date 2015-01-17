<?php
namespace User\Controller;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Form\DoubleOptIn\Confirmed;
use User\Form\DoubleOptIn\RequestForm;
use User\Service\DoubleOptInService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ResponseInterface as Response;

class DoubleOptInController extends AbstractActionController {

    /** @var ChangePasswordForm */
    protected $confirmedForm;

    /** @var ForgotPasswordService */
    protected $forgotPasswordService;

    public function __construct(RequestForm $requestForm, Confirmed $confirmedForm, DoubleOptInService $doubleOptInService) {
        $this->requestForm = $requestForm;
        $this->confirmedForm = $confirmedForm;
        $this->doubleOptInService = $doubleOptInService;
    }

    public function indexAction() {
        $form = $this->requestForm;
        $doubleOptInService = $this->doubleOptInService;

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $request = $this->getRequest();
        $form->setData($request->getPost());

        $this->doubleOptInService->request($request->getPost('email'));

        //$this->doubleOptInService->request("chregi.sommer@gmail.com");

        $viewModel->setTemplate('double-opt-in/request.phtml');

        $redirectUrl = $this->url()->fromRoute('double-opt-in');
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }
        /*
          if ($this->doubleOptInService->request("chregi.sommer@gmail.com")) {
          $viewModel->setTemplate('double-opt-in/confirmation/sent-email.phtml');
          return $viewModel;
          }
         */
        return $viewModel;
    }

    public function confirmedAction() {
        $this->layout('layout/layout');
        $form = $this->confirmedForm;
        $doubleOptInService = $this->doubleOptInService;

        $token = $this->params('token');
        $user = $doubleOptInService->getUserFromToken($token);
        if (!$user) {
            $viewModel = new ViewModel([
                'form' => $form,
            ]);
            $this->layout('layout/expired');
            $viewModel->setTemplate('double-opt-in/expired.phtml');
            return $viewModel;
        }
        $email = $user->getEmail();

        $form->add([
            'name' => 'email',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => [
                'class' => 'form-control',
                'value' => $email,
            ],
            'options' => [
                'type' => 'email',
                'label' => 'Email',
            ],
        ]);
        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        if (!$user) {
            $this->layout('layout/expired');
            $viewModel->setTemplate('double-opt-in/expired.phtml');
            return $viewModel;
        }

        $viewModel->setTemplate('double-opt-in/confirmed.phtml');

        $redirectUrl = $this->url()->fromRoute('double-opt-in/confirmed', ['token' => $token]);
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($doubleOptInService->confirmed($prg, $user)) {
            $viewModel->setTemplate('double-opt-in/confirmation/optin-confirmed.phtml');
            return $viewModel;
        }

        $form->setData([
            'confirmed' => null,
            'confirm_account' => null,
        ]);

        return $viewModel;
    }

}
