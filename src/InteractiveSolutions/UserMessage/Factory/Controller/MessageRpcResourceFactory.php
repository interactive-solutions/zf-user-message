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
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;


class MessageRpcResourceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MessageRpcResource
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var EntityManager $entityManager */
        $entityManager = $container->get('InteractiveSolutions\Message\ObjectManager');

        /* @var  MessageRepository $messageRepository */
        $messageRepository = $entityManager->getRepository(MessageEntity::class);

        /* @var MessageService $messageService */
        $messageService = $container->get(MessageService::class);

        return new MessageRpcResource(
            $messageRepository,
            $messageService
        );
    }
}
