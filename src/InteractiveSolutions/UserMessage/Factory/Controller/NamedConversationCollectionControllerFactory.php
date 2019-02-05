<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use InteractiveSolutions\UserMessage\Controller\NamedConversationCollectionController;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

final class NamedConversationCollectionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NamedConversationCollectionController
    {
        return new NamedConversationCollectionController(
            $container->get(ConversationService::class),
            $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(NamedConversationEntity::class)
        );
    }
}
