<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use InteractiveSolutions\UserMessage\Controller\MessageCollectionController;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class MessageCollectionControllerFactory
 */
class MessageCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageCollectionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageCollectionController(
            $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class)
        );
    }
}
