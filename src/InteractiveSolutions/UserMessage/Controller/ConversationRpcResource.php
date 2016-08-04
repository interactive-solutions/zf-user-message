<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Controller;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\ConversationRepositoryInterface;
use InteractiveSolutions\UserMessage\Repository\Exception\ConversationNotFound;
use InteractiveSolutions\UserMessage\Service\ConversationServiceInterface;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use RuntimeException;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use ZfrRest\Http\Exception\Client\BadRequestException;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Http\Exception\Client\UnprocessableEntityException;
use ZfrRest\View\Model\ResourceViewModel;

/**
 * Class ConversationRpcResource
 *
 * @method boolean isGranted($permission, $context = null)
 * @method Response getResponse
 * @method Request getRequest
 */
final class ConversationRpcResource extends AbstractActionController
{
    /**
     * @var ConversationRepositoryInterface
     */
    private $conversationRepository;

    /**
     * @var EntityRepository
     */
    private $userRepository;

    /**
     * @var ConversationServiceInterface
     */
    private $conversationService;

    /**
     * ConversationRpcResource constructor.
     * @param ConversationRepositoryInterface $conversationRepository
     * @param EntityRepository $userRepository
     * @param ConversationServiceInterface $conversationService
     */
    public function __construct(
        ConversationRepositoryInterface $conversationRepository,
        EntityRepository $userRepository,
        ConversationServiceInterface $conversationService
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->userRepository         = $userRepository;
        $this->conversationService    = $conversationService;
    }

    /**
     * Load conversation between users
     *
     * @return ResourceViewModel
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function loadAction(): ResourceViewModel
    {
        if (!$this->isGranted(UserMessagePermissions::START_CONVERSATION)) {
            throw new ForbiddenException();
        }

        /* @var MessageUserInterface $target */
        $target = $this->userRepository->findOneBy(['id' => $this->params()->fromQuery('target')]);
        if (! $target) {
            throw new NotFoundException('Target user not found');
        }

        try {
            $conversation = $this->conversationRepository->getConversationBetween($this->identity(), $target);
        } catch (ConversationNotFound $e) {
            $conversation = $this->conversationService->createBetween($this->identity(), $target);
        }

        return new ResourceViewModel(['conversation' => $conversation], ['template' => 'conversations/conversation']);
    }

    /**
     * Add participant to conversation
     *
     * @return Response
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnprocessableEntityException
     */
    public function addParticipantAction(): Response
    {
       $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::ADD_PARTICIPANT, $conversation)) {
            throw new ForbiddenException('User does not have permission to add a user to this conversation');
        }

        $user = $this->getParticipant();
        $this->conversationService->addParticipant($conversation, $user);

        return $this->getResponse()->setStatusCode(Response::STATUS_CODE_204);
    }

    /**
     * Remove participant from conversation
     *
     * @return Response
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws UnprocessableEntityException
     */
    public function removeParticipantAction(): Response
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::REMOVE_PARTICIPANT, $conversation)) {
            throw new ForbiddenException('User does not have permission to remove a user from this conversation');
        }

        $user = $this->getParticipant();
        $this->conversationService->removeParticipant($conversation, $user);

        return $this->getResponse()->setStatusCode(Response::STATUS_CODE_204);
    }

    /**
     * Get participant from json body
     *
     * @return MessageUserInterface
     * @throws \ZfrRest\Http\Exception\Client\NotFoundException
     * @throws \ZfrRest\Http\Exception\Client\UnprocessableEntityException
     * @throws \ZfrRest\Http\Exception\Client\BadRequestException
     */
    private function getParticipant(): MessageUserInterface
    {
        try {
            $data = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        } catch (RuntimeException $e) {
            throw new BadRequestException('Invalid json body provided');
        }

        if (!isset($data['participant_id'])) {
            throw new UnprocessableEntityException('No participant id provided');
        }

        /* @var MessageUserInterface $user */
        $user = $this->userRepository->findOneBy(['id' => $data['participant_id']]);

        if (!$user) {
            throw new NotFoundException('Participant does not exist');
        }

        return $user;
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
