<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use InteractiveSolutions\UserMessage\Controller\NamedConversationResourceController;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


final class NamedConversationResourceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NamedConversationResourceController
    {
        return new NamedConversationResourceController(
            $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(NamedConversationEntity::class),
            $container->get(ConversationService::class)
        );
    }
}
