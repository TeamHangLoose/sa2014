<?php
namespace User\Options;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
interface ModuleOptionsInterface
{
    /**
     * Get token entity
     *
     * @return string
     */
    public function getTokenEntity();

    /**
     * The lifetime of the tokens
     *
     * @return int
     */
    public function getTokenHours();

    /**
     * Get mail transporter
     *
     * @return string
     */
       public function getMailTransporter();
   
}
