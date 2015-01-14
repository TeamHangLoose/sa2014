<?php
namespace User\Factory\Service;
/* 
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author  abbts2015 B14.if4.1 G.3
 */
use User\Service\MailService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return MailService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \User\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('User\Options\ModuleOptions');

        /** @var \User\Service\MailTransporterInterface $mailTransporter */
        $mailTransporter = $serviceLocator->get($moduleOptions->getMailTransporter());

        return new MailService($mailTransporter);
    }
}
