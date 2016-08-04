<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Entity\GroupConversationEntity;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\InputFilter\ConversationInputFilter;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\Http\PhpEnvironment\Response;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class ConversationCollectionController
 *
 * @method Response getResponse
 * @method MessageUserInterface identity()
 * @method boolean isGranted($permission, $context = null)
 */
final class ConversationCollectionController extends AbstractRestfulController
{
    /**
     * @var ConversationRepository
     */
    protected $conversationRepository;

    /**
     * @var ConversationService
     */
    protected $conversationService;

    /**
     * @var EntityRepository
     */
    protected $userRepository;

    /**
     * @param ConversationRepository $conversationRepository
     * @param ConversationService $conversationService
     * @param EntityRepository $userRepository
     */
    public function __construct(
        ConversationRepository $conversationRepository,
        ConversationService $conversationService,
        EntityRepository $userRepository
    )
    {
        $this->userRepository         = $userRepository;
        $this->conversationService    = $conversationService;
        $this->conversationRepository = $conversationRepository;
    }

    /**
     *
     * @throws ForbiddenException
     *
     * @return ResourceViewModel
     */
    public function get()
    {
        if (!$this->isGranted(UserMessagePermissions::GET_ALL_CONVERSATIONS)) {
            throw new ForbiddenException('User must be logged on to retrieve conversations');
        }

        $paginator = $this->conversationRepository->getConversations($this->identity());
        $paginator->setCurrentPageNumber($this->params()->fromQuery('offset', 0));
        $paginator->setItemCountPerPage($this->params()->fromQuery('limit', 25));

        return new ResourceViewModel(['paginator' => $paginator], ['template' => 'conversations/conversations']);
    }

    /**
     * @return ResourceViewModel
     *
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function post()
    {
        if (!$this->isGranted(UserMessagePermissions::START_CONVERSATION)) {
            throw new ForbiddenException('User must be logged on to start a conversation');
        }

        $values = $this->validateIncomingData(ConversationInputFilter::class);

        /* @var MessageUserInterface[] $user */
        $users = $this->userRepository->findBy(['id' => $values['participants']]);

        $conversation = new GroupConversationEntity($users);
        $this->conversationService->create($conversation);

        return new ResourceViewModel(['conversation' => $conversation], ['template' => 'conversations/conversation']);
    }
}
