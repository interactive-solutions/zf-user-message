<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\NamedConversationRpcResource;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Repository\NamedConversationRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;


final class NamedConversationRpcResourceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NamedConversationRpcResource
    {
        /* @var EntityManager $entityManager */
        $entityManager = $container->get('InteractiveSolutions\Message\ObjectManager');

        /* @var  NamedConversationRepository $conversationRepository */
        $conversationRepository = $entityManager->getRepository(NamedConversationEntity::class);
        $userRepository         = $entityManager->getRepository(MessageUserInterface::class);

        /* @var ConversationService $conversationService */
        $conversationService = $container->get(ConversationService::class);

        return new NamedConversationRpcResource(
            $conversationRepository,
            $userRepository,
            $conversationService
        );
    }
}
