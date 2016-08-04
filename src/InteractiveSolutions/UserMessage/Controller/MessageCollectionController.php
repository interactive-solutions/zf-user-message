<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use InteractiveSolutions\UserMessage\UserMessagePermissions;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\MessageRepository;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Mvc\Controller\AbstractRestfulController;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class MessageCollectionController
 *
 * @method MessageUserInterface identity()
 * @method boolean isGranted($permission, $context = null)
 */
final class MessageCollectionController extends AbstractRestfulController
{
    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return ResourceViewModel
     * @throws \ZfrRest\Http\Exception\Client\ForbiddenException
     */
    public function get(): ResourceViewModel
    {
        $identity = $this->identity();

        if (!$this->isGranted(UserMessagePermissions::GET_ALL_MESSAGES)) {
            throw new ForbiddenException('You must be authenticated to view messages.');
        }

        $paginator = $this->messageRepository->getMessagesAssociatedWith($identity);
        $paginator->setCurrentPageNumber($this->params()->fromQuery('offset', 1));
        $paginator->setItemCountPerPage($this->params()->fromQuery('limit', 50));

        return new ResourceViewModel(['paginator' => $paginator], ['template' => 'messages/messages']);
    }
}
