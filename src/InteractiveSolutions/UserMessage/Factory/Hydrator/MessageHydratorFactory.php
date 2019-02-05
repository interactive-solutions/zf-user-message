<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Hydrator;

use InteractiveSolutions\UserMessage\Hydrator\MessageHydrator;
use InteractiveSolutions\UserMessage\Hydrator\ParticipantsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class MessageHydratorFactory
 */
class MessageHydratorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageHydrator($container->get(ParticipantsHydrator::class));
    }
}
