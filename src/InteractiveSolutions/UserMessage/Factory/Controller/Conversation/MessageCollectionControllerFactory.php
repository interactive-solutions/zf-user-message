<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller\Conversation;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Controller\Conversation\MessageCollectionController;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use InteractiveSolutions\UserMessage\Service\MessageService;

use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConversationMessageControllerFactory
 */
class MessageCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageCollectionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        /* @var MessageService $messageService */
        $messageService = $container->get(MessageService::class);

        /* @var ConversationRepository $conversationRepository */
        $conversationRepository = $container->get('InteractiveSolutions\Message\ObjectManager')->getRepository(AbstractConversationEntity::class);

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
