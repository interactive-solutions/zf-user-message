<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Service;

use InteractiveSolutions\UserMessage\Service\MessageService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MessageServiceFactory
 */
class MessageServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return MessageService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MessageService(
            $serviceLocator->get('InteractiveSolutions\Message\ObjectManager')
        );
    }
}
