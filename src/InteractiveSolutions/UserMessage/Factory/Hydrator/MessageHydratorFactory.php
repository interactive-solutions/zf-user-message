<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Hydrator;

use InteractiveSolutions\UserMessage\Hydrator\MessageHydrator;
use InteractiveSolutions\UserMessage\Hydrator\ParticipantsHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MessageHydratorFactory
 */
class MessageHydratorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return MessageHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MessageHydrator($serviceLocator->get(ParticipantsHydrator::class));
    }
}
