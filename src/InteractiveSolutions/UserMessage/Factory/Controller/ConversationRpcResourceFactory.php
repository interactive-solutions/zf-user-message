<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\ConversationRpcResource;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConversationRpcResourceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface|ControllerManager $controllerManager
     * @return ConversationRpcResource
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sl = $controllerManager->getServiceLocator();

        /* @var EntityManager $entityManager */
        $entityManager = $sl->get('InteractiveSolutions\Message\ObjectManager');

        /* @var  ConversationRepository $conversationRepository */
        $conversationRepository = $entityManager->getRepository(AbstractConversationEntity::class);
        $userRepository         = $entityManager->getRepository(MessageUserInterface::class);

        /* @var ConversationService $conversationService */
        $conversationService = $sl->get(ConversationService::class);

        return new ConversationRpcResource(
            $conversationRepository,
            $userRepository,
            $conversationService
        );
    }
}
