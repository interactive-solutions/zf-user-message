<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Hydrator;


use InteractiveSolutions\UserMessage\Hydrator\ConversationHydrator;
use InteractiveSolutions\UserMessage\Hydrator\ParticipantsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ConversationHydratorFactory
 */
class ConversationHydratorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ConversationHydrator
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ConversationHydrator($container->get(ParticipantsHydrator::class));
    }
}
