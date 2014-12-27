<?php

namespace User\Service;

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
        $this->transporter->send(
                $options, $variables
        );
    }

}
