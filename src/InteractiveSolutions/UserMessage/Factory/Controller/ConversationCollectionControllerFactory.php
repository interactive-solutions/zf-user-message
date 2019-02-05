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
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ConversationCollectionControllerFactory
 */
class ConversationCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ConversationCollectionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var EntityManager $entityManager
         * @var ConversationRepository $conversationRepository
         * @var ConversationService $conversationService
         */
        $entityManager                  = $container->get('InteractiveSolutions\Message\ObjectManager');
        $conversationRepository         = $entityManager->getRepository(AbstractConversationEntity::class);
        $conversationService            = $container->get(ConversationService::class);
        $messageUserInterfaceRepository = $entityManager->getRepository(MessageUserInterface::class);

        return new ConversationCollectionController(
            $conversationRepository,
            $conversationService,
            $messageUserInterfaceRepository
        );
    }
}
