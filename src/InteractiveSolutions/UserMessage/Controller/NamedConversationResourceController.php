<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\InputFilter\NamedConversationInputFilter;
use InteractiveSolutions\UserMessage\Repository\Exception\NamedConversationNotFound;
use InteractiveSolutions\UserMessage\Repository\NamedConversationRepositoryInterface;
use InteractiveSolutions\UserMessage\Service\ConversationServiceInterface;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class NamedConversationResourceController
 *
 * @method boolean isGranted($permission, $context = null)
 */
final class NamedConversationResourceController extends AbstractRestfulController
{
    /**
     * @var NamedConversationRepositoryInterface
     */
    private $repository;

    /**
     * @var ConversationServiceInterface
     */
    private $service;

    /**
     * NamedConversationResourceController constructor.
     * @param NamedConversationRepositoryInterface $repository
     * @param ConversationServiceInterface $service
     */
    public function __construct(NamedConversationRepositoryInterface $repository, ConversationServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }

    public function get(): ResourceViewModel
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::GET_NAMED_CONVERSATION, $conversation)) {
            throw new ForbiddenException('You are not allowed to view this conversation');
        }

        return new ResourceViewModel(
            ['conversation' => $conversation],
            ['template' => 'named-conversations/conversation']
        );
    }

    public function put(): ResourceViewModel
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::UPDATE_NAMED_CONVERSATION, $conversation)) {
            throw new ForbiddenException('User is not allowed to update the name of this conversation');
        }

        $values = $this->validateIncomingData(NamedConversationInputFilter::class);

        NamedConversationEntity::update($conversation, $values);
        $this->service->update($conversation);

        return new ResourceViewModel(
            ['conversation' => $conversation],
            ['template' => 'named-conversations/conversation']
        );
    }

    /**
     * Extract conversation from route
     * @return NamedConversationEntity
     * @throws NotFoundException
     */
    private function getConversation(): NamedConversationEntity
    {
        try {
            $conversation = $this->repository->getBySlug($this->params('slug'));
        } catch (NamedConversationNotFound $e) {
            throw new NotFoundException('No conversation with that name exists');
        }

        return $conversation;
    }
}
