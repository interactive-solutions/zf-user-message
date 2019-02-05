<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\ConversationRpcResource;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\DirectConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ConversationRpcResourceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ConversationRpcResource
     */
    public function createService(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var EntityManager $entityManager */
        $entityManager = $container->get('InteractiveSolutions\Message\ObjectManager');

        /* @var  ConversationRepository $conversationRepository */
        $conversationRepository = $entityManager->getRepository(AbstractConversationEntity::class);
        /* @var ConversationRepository $pmRepository */
        $pmRepository           = $entityManager->getRepository(DirectConversationEntity::class);
        $userRepository         = $entityManager->getRepository(MessageUserInterface::class);

        /* @var ConversationService $conversationService */
        $conversationService = $container->get(ConversationService::class);

        return new ConversationRpcResource(
            $conversationRepository,
            $pmRepository,
            $userRepository,
            $conversationService
        );
    }
}
