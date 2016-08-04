<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Hydrator;


use InteractiveSolutions\UserMessage\Hydrator\ConversationHydrator;
use InteractiveSolutions\UserMessage\Hydrator\ParticipantsHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConversationHydratorFactory
 */
class ConversationHydratorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ConversationHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ConversationHydrator($serviceLocator->get(ParticipantsHydrator::class));
    }
}
