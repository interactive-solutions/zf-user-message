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
use Zend\Mvc\Controller\ControllerManager;

final class NamedConversationCollectionControllerFactory
{
    public function __invoke(ControllerManager $controllerManager): NamedConversationCollectionController
    {
        $sl = $controllerManager->getServiceLocator();

        return new NamedConversationCollectionController(
            $sl->get(ConversationService::class),
            $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(NamedConversationEntity::class)
        );
    }
}
