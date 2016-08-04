<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;


use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\MessageRpcResource;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use InteractiveSolutions\UserMessage\Service\MessageService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MessageRpcResourceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface|ControllerManager $controllerManager
     * @return MessageRpcResource
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sl = $controllerManager->getServiceLocator();

        /* @var EntityManager $entityManager */
        $entityManager = $sl->get('InteractiveSolutions\Message\ObjectManager');

        /* @var  MessageRepository $messageRepository */
        $messageRepository = $entityManager->getRepository(MessageEntity::class);

        /* @var MessageService $messageService */
        $messageService = $sl->get(MessageService::class);

        return new MessageRpcResource(
            $messageRepository,
            $messageService
        );
    }
}
