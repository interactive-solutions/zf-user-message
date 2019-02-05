<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Factory\Controller\NamedConversation;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Controller\NamedConversation\MessageCollectionController;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use InteractiveSolutions\UserMessage\Repository\NamedConversationRepository;
use InteractiveSolutions\UserMessage\Service\MessageService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

final class MessageCollectionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MessageCollectionController
    {
        /* @var MessageService $messageService */
        $messageService = $container->get(MessageService::class);

        /* @var NamedConversationRepository $conversationRepository */
        $conversationRepository = $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(NamedConversationEntity::class);

        /* @var MessageRepository $messageRepository */
        $messageRepository = $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class);

        /* @var EntityRepository $userRepository */
        $userRepository = $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageUserInterface::class);

        return new MessageCollectionController(
            $messageService,
            $conversationRepository,
            $messageRepository,
            $userRepository
        );
    }
}
