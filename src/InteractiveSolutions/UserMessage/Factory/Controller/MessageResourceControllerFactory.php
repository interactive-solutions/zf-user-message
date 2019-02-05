<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use InteractiveSolutions\UserMessage\Controller\MessageResourceController;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class MessageResourceControllerFactory
 */
class MessageResourceControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageResourceController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageResourceController(
            $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class)
        );
    }
}
