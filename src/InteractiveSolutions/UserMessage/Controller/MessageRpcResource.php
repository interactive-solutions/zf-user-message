<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\Exception\MessageNotFound;
use InteractiveSolutions\UserMessage\Repository\MessageRepositoryInterface;
use InteractiveSolutions\UserMessage\Service\MessageServiceInterface;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;

/**
 * Class MessageRpcResource
 *
 * @method boolean isGranted($permission, $context = null)
 * @method Response getResponse
 */
class MessageRpcResource extends AbstractActionController
{
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    /**
     * @var MessageServiceInterface
     */
    private $messageService;

    /**
     * MessageRpcResource constructor.
     * @param MessageRepositoryInterface $messageRepository
     * @param MessageServiceInterface $messageService
     */
    public function __construct(MessageRepositoryInterface $messageRepository, MessageServiceInterface $messageService)
    {
        $this->messageRepository = $messageRepository;
        $this->messageService    = $messageService;
    }

    public function readAction()
    {
        $message = $this->getMessage();

        if (!$this->isGranted(UserMessagePermissions::GET_MESSAGE, $message->getConversation())) {
            throw new ForbiddenException('User does not have permission to view this message');
        }

        /* @var MessageUserInterface $user */
        $user = $this->identity();

        $this->messageService->markAsReadByUser($message, $user);

        return $this->getResponse()->setStatusCode(Response::STATUS_CODE_204);
    }

    /**
     * Extract message from route
     *
     * @return MessageEntity
     * @throws \ZfrRest\Http\Exception\Client\NotFoundException
     */
    private function getMessage(): MessageEntity
    {
        try {
            $message = $this->messageRepository->getById((int) $this->params('message_id'));
        } catch (MessageNotFound $e) {
            throw new NotFoundException('Message does not exist');
        }

        return $message;
    }
}
