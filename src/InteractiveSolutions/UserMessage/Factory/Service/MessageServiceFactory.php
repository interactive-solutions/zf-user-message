<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Service;

use InteractiveSolutions\UserMessage\Service\MessageService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;


/**
 * Class MessageServiceFactory
 */
class MessageServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageService(
            $container->get('InteractiveSolutions\Message\ObjectManager')
        );
    }
}
