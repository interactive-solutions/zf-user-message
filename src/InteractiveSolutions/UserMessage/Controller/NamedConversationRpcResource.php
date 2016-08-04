<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Controller;

use Doctrine\ORM\EntityRepository;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\NamedConversationNotFound;
use InteractiveSolutions\UserMessage\Repository\NamedConversationRepositoryInterface;
use InteractiveSolutions\UserMessage\Service\ConversationServiceInterface;
use InteractiveSolutions\UserMessage\UserMessagePermissions;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Exception\RuntimeException;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use ZfrRest\Http\Exception\Client\BadRequestException;
use ZfrRest\Http\Exception\Client\ForbiddenException;
use ZfrRest\Http\Exception\Client\NotFoundException;
use ZfrRest\Http\Exception\Client\UnprocessableEntityException;

/**
 * Class NamedConversationRpcResource
 * 
 * @method Response getResponse
 * @method Request getRequest
 * @method boolean isGranted($permission, $context = null)
 */
final class NamedConversationRpcResource extends AbstractActionController
{
    /**
     * @var NamedConversationRepositoryInterface
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
     * NamedConversationRpcResource constructor.
     * @param NamedConversationRepositoryInterface $conversationRepository
     * @param EntityRepository $userRepository
     * @param ConversationServiceInterface $conversationService
     */
    public function __construct(
        NamedConversationRepositoryInterface $conversationRepository,
        EntityRepository $userRepository,
        ConversationServiceInterface $conversationService
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->userRepository         = $userRepository;
        $this->conversationService    = $conversationService;
    }

    public function addParticipantAction(): Response
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::ADD_PARTICIPANT, $conversation)) {
            throw new ForbiddenException('User does not have permission to add a user to this conversation');
        }

        $data = $this->validate();
        $user = $this->getParticipant($data);
        $this->conversationService->addParticipant($conversation, $user);

        return $this->getResponse()->setStatusCode(Response::STATUS_CODE_204);
    }

    public function removeParticipantAction()
    {
        $conversation = $this->getConversation();

        if (!$this->isGranted(UserMessagePermissions::REMOVE_PARTICIPANT, $conversation)) {
            throw new ForbiddenException('User does not have permission to remove a user from this conversation');
        }

        $data = $this->validate();
        $user = $this->getParticipant($data);
        $this->conversationService->removeParticipant($conversation, $user);

        return $this->getResponse()->setStatusCode(Response::STATUS_CODE_204);
    }

    /**
     * Validate json body
     *
     * @return array
     * @throws \ZfrRest\Http\Exception\Client\UnprocessableEntityException
     * @throws \ZfrRest\Http\Exception\Client\BadRequestException
     */
    private function validate(): array
    {
        try {
            $data = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        } catch (RuntimeException $e) {
            throw new BadRequestException('Invalid json body provided');
        }

        if (!isset($data['participant_id'])) {
            throw new UnprocessableEntityException('No participant id provided');
        }
    }

    /**
     * Extract participant from provided data
     *
     * @param array $data
     * @return MessageUserInterface
     * @throws NotFoundException
     */
    private function getParticipant(array $data): MessageUserInterface
    {
        $user = $this->userRepository->findOneBy(['id' => $data['participant_id']]);

        if (!$user) {
            throw new NotFoundException('Participant does not exist');
        }

        return $user;
    }

    /**
     * Extract conversation from route
     *
     * @return NamedConversationEntity
     * @throws NotFoundException
     */
    private function getConversation(): NamedConversationEntity
    {
        try {
            $conversation = $this->conversationRepository->getBySlug($this->params('slug'));
        } catch (NamedConversationNotFound $e) {
            throw new NotFoundException('No conversation with that slug exist');
        }

        return $conversation;
    }
}
