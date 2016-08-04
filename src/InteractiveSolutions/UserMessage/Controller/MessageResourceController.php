<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\MessageNotFound;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\MessageRepositoryInterface;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class MessageResourceController
 *
 * @method MessageUserInterface getIdentity()
 * @method boolean isGranted($permission, $context = null)
 */
final class MessageResourceController extends AbstractRestfulController
{
    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return ResourceViewModel
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function get()
    {
        $message = $this->getMessage();

        if (!$this->isGranted(UserMessagePermissions::GET_MESSAGE, $message->getConversation())) {
            throw new ForbiddenException('You dont have enough privileges to view this message.');
        }

        return new ResourceViewModel(['message' => $message], ['template' => 'messages/message']);
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
