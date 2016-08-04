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
use Zend\Mvc\Controller\ControllerManager;

final class NamedConversationResourceControllerFactory
{
    public function __invoke(ControllerManager $controllerManager): NamedConversationResourceController
    {
        $container = $controllerManager->getServiceLocator();

        return new NamedConversationResourceController(
            $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(NamedConversationEntity::class),
            $container->get(ConversationService::class)
        );
    }
}
