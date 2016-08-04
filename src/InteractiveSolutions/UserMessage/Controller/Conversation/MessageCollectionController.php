<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller\Conversation;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\ConversationNotFound;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Hydrator\MessageHydrator;
use InteractiveSolutions\UserMessage\InputFilter\MessageInputFilter;
use InteractiveSolutions\UserMessage\Repository\ConversationRepositoryInterface;
use InteractiveSolutions\UserMessage\Repository\MessageRepositoryInterface;
use InteractiveSolutions\UserMessage\Service\MessageService;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class ConversationMessageController
 *
 * @method MessageUserInterface identity()
 * @method boolean isGranted($permission, $context)
 */
final class MessageCollectionController extends AbstractRestfulController
{
    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var ConversationRepositoryInterface
     */
    protected $conversationRepository;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @var EntityRepository
     */
    protected $userRepository;

    /**
     * @param MessageService $messageService
     * @param ConversationRepositoryInterface $conversationRepository
     * @param MessageRepositoryInterface $messageRepository
     * @param EntityRepository $userRepository
     */
    public function __construct(
        MessageService $messageService,
        ConversationRepositoryInterface $conversationRepository,
        MessageRepositoryInterface $messageRepository,
        EntityRepository $userRepository
    ) {
        $this->messageService         = $messageService;
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository      = $messageRepository;
        $this->userRepository         = $userRepository;
    }

    /**
     * @return ResourceViewModel
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function post()
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::SEND_MESSAGE, $conversation)) {
            throw new ForbiddenException('User does not have permission to send a message in this conversation');
        }

        $values = $this->validateIncomingData(MessageInputFilter::class);

        $sender = array_key_exists('sender', $values) && $values['sender'] ? $this->userRepository->findOneBy([
            'id' => $values['sender']
        ]) : $this->identity();

        $messageEntity = new MessageEntity($conversation, $sender, $values);

        $this->messageService->create($messageEntity);

        return new ResourceViewModel(['message' => $messageEntity], ['template' => 'messages/message']);
    }

    /**
     * @return ResourceViewModel
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function get()
    {
       $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::GET_CONVERSATION, $conversation)) {
            throw new ForbiddenException('User does not have permission to view this conversation');
        }

        $paginator = $this->messageRepository->getByConversation($conversation);
        $paginator->setCurrentPageNumber($this->params()->fromQuery('offset', 1));
        $paginator->setItemCountPerPage($this->params()->fromQuery('limit', 50));

        return new ResourceViewModel(['paginator' => $paginator], ['template' => 'messages/messages']);
    }

    /**
     * Extract conversation from route
     *
     * @return AbstractConversationEntity
     * @throws NotFoundException
     */
    private function getConversation(): AbstractConversationEntity
    {
        try {
            $conversation = $this->conversationRepository->getById((int) $this->params('conversation_id'));
        } catch (ConversationNotFound $e) {
            throw new NotFoundException('No conversation with that slug exists');
        }

        return $conversation;
    }
}
