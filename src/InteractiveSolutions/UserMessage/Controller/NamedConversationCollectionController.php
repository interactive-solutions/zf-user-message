<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\InputFilter\NamedConversationInputFilter;
use InteractiveSolutions\UserMessage\Repository\NamedConversationRepositoryInterface;
use InteractiveSolutions\UserMessage\Service\ConversationServiceInterface;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use Zend\Http\Response;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class ConversationCollectionController
 *
 * @method Response getResponse
 * @method boolean isGranted($permission, $context = null)
 */
final class NamedConversationCollectionController extends AbstractRestfulController
{
    /**
     * @var NamedConversationRepositoryInterface
     */
    private $conversationRepository;

    /**
     * @var ConversationServiceInterface
     */
    private $conversationService;

    /**
     * @param ConversationServiceInterface $conversationService
     * @param NamedConversationRepositoryInterface $conversationRepository
     */
    public function __construct(
        ConversationServiceInterface $conversationService,
        NamedConversationRepositoryInterface $conversationRepository
    ) {
        $this->conversationService    = $conversationService;
        $this->conversationRepository = $conversationRepository;
    }

    public function get(): ResourceViewModel
    {
        if (!$this->isGranted(UserMessagePermissions::GET_ALL_CONVERSATIONS)) {
            throw new ForbiddenException('User must be logged on to retrieve conversations');
        }

        $paginator = $this->conversationRepository->getAll();
        $paginator->setCurrentPageNumber($this->params()->fromQuery('offset', 0));
        $paginator->setItemCountPerPage($this->params()->fromQuery('limit', 25));

        return new ResourceViewModel(['paginator' => $paginator], ['template' => 'named-conversations/conversations']);
    }

    /**
     * @return ResourceViewModel
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function post(): ResourceViewModel
    {
        if (!$this->isGranted(UserMessagePermissions::START_NAMED_CONVERSATION)) {
            throw new ForbiddenException('You don\'t have permission to start a named conversation');
        }

        $values = $this->validateIncomingData(NamedConversationInputFilter::class);

        $conversation = new NamedConversationEntity($values);
        $this->conversationService->create($conversation);

        return new ResourceViewModel(
            ['conversation' => $conversation],
            ['template' => 'named-conversations/conversation']
        );
    }
}
