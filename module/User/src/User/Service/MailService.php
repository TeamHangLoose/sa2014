<?php
namespace User\Service;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Entity\TokenInterface;
use ZfcUser\Entity\UserInterface;

class MailService {

    /** @var MailTransporterInterface */
    protected $transporter;

    public function __construct($transporter) {
        $this->transporter = $transporter;
    }

    public function sendToken(TokenInterface $token, UserInterface $user,array $options) {
        $variables = [
            'name' => $user->getDisplayName(),
            'token' => $token->getToken(),
        ];
        try {
             $this->transporter->send(
                $options, $variables
        );
        } catch (Exception $ex) {
            return false;
        }
       
    }

}
