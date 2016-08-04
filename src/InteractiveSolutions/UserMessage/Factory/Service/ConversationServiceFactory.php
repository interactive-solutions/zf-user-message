<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Service;

use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConversationServiceFactory
 */
class ConversationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ConversationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ConversationService(
            $serviceLocator->get('InteractiveSolutions\Message\ObjectManager')
        );
    }
}
