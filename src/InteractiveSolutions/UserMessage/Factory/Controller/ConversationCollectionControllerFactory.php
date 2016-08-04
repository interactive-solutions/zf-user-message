<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\ConversationCollectionController;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConversationCollectionControllerFactory
 */
class ConversationCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return ConversationCollectionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var ControllerManager $sl
         * @var EntityManager $entityManager
         * @var ConversationRepository $conversationRepository
         * @var ConversationService $conversationService
         */
        $sl                             = $serviceLocator->getServiceLocator();
        $entityManager                  = $sl->get('InteractiveSolutions\Message\ObjectManager');
        $conversationRepository         = $entityManager->getRepository(AbstractConversationEntity::class);
        $conversationService            = $sl->get(ConversationService::class);
        $messageUserInterfaceRepository = $entityManager->getRepository(MessageUserInterface::class);

        return new ConversationCollectionController(
            $conversationRepository,
            $conversationService,
            $messageUserInterfaceRepository
        );
    }
}
