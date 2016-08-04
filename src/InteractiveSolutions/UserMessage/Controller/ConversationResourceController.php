<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\ConversationNotFound;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepositoryInterface;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class ConversationResourceController
 *
 * @method MessageUserInterface identity()
 * @method boolean isGranted($permission, $context = null)
 */
final class ConversationResourceController extends AbstractRestfulController
{
    /**
     * @var ConversationRepositoryInterface
     */
    protected $conversationRepository;

    /**
     * @param ConversationRepositoryInterface $conversationRepository
     */
    public function __construct(ConversationRepositoryInterface $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    /**
     * @return ResourceViewModel
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function get()
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::GET_CONVERSATION, $conversation)) {
            throw new ForbiddenException('User does not have permission to view this conversation');
        }

        return new ResourceViewModel(['conversation' => $conversation], ['template' => 'conversations/conversation']);
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
