<?php
namespace User\Service;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use Zend\Mail\Message;

interface MailTransporterInterface
{
    /**
     * Send a message with given variables for the body
     * Valid options are:
     * - to:              the email address to send the message to (required)
     * - subject:         the subject of the message (required)
     * - template:        the view name of the (html) template (required)
     * - to_name:         the name of the user to send to
     * - cc:              an email address to send a cc to
     * - cc_name:         the name of the user to cc
     * - bcc:             an email address to send a bcc to
     * - bcc_name:        the name of the user to bcc
     * - from:            the email address the message came from
     * - from_name:       the name of the user from the from address
     * - reply_to:        the email address to reply to
     * - reply_to_name:   the name of the user from the reply to address
     * - template_text:   the plain text version of the template
     * - attachments:     an array of attachments (not implemented currently)
     * - headers:         a key/value array of additional headers to set
     * @return void
     */
    public function send(array $options, array $variables = array(), Message $message = null);
}
