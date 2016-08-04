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
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConversationMessageControllerFactory
 */
class MessageCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return MessageCollectionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = $serviceLocator->getServiceLocator();

        /* @var MessageService $messageService */
        $messageService = $sl->get(MessageService::class);

        /* @var ConversationRepository $conversationRepository */
        $conversationRepository = $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(AbstractConversationEntity::class);

        /* @var MessageRepository $messageRepository */
        $messageRepository = $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class);

        /* @var EntityRepository $userRepository */
        $userRepository = $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageUserInterface::class);

        return new MessageCollectionController(
            $messageService,
            $conversationRepository,
            $messageRepository,
            $userRepository
        );
    }
}
