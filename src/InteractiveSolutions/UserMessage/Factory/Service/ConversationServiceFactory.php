<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Service;

use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ConversationServiceFactory
 */
class ConversationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ConversationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ConversationService(
            $container->get('InteractiveSolutions\Message\ObjectManager')
        );
    }
}
