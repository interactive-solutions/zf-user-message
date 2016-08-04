<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Service;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\DirectConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Event\ConversationEvent;
use InteractiveSolutions\UserMessage\Service\Exception\IllegalOperationException;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

/**
 * Class ConversationService
 */
class ConversationService implements EventManagerAwareInterface, ConversationServiceInterface
{
    use EventManagerAwareTrait;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function slugify(string $name): string
    {
        $slug = trim($name); // trim the string
        $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
        $slug = str_replace(' ', '-', $slug); // replace spaces by dashes
        $slug = strtolower($slug);  // make it lowercase

        return $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function create(AbstractConversationEntity $conversation)
    {
        $this->objectManager->persist($conversation);
        $this->objectManager->flush();

        $this
            ->getEventManager()
            ->trigger(new ConversationEvent(ConversationEvent::CREATED, $this, ['conversation' => $conversation]));

        return $conversation;
    }

    /**
     * {@inheritdoc}
     */
    public function update(NamedConversationEntity $conversation)
    {
        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function addParticipant(AbstractConversationEntity $conversation, MessageUserInterface $participant)
    {
        if ($conversation->getType() === DirectConversationEntity::TYPE) {
            throw IllegalOperationException::editingParticipantsOnDirectConversation();
        }

        AbstractConversationEntity::addParticipant($conversation, $participant);

        $eventArgs = [
            'conversation' => $conversation,
            'participant'  => $participant
        ];

        $this
            ->getEventManager()
            ->trigger(new ConversationEvent(ConversationEvent::PARTICIPANT_ADDED, $this, $eventArgs));

        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function removeParticipant(AbstractConversationEntity $conversation, MessageUserInterface $participant)
    {
        if ($conversation->getType() === DirectConversationEntity::TYPE) {
            throw IllegalOperationException::editingParticipantsOnDirectConversation();
        }

        AbstractConversationEntity::removeParticipant($conversation, $participant);

        $eventArgs = [
            'conversation' => $conversation,
            'participant'  => $participant
        ];

        $this
            ->getEventManager()
            ->trigger(new ConversationEvent(ConversationEvent::PARTICIPANT_REMOVED, $this, $eventArgs));

        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function createBetween(MessageUserInterface $identity, MessageUserInterface $target)
    {
        $conversation = new DirectConversationEntity([$identity, $target]);

        return $this->create($conversation);
    }
}
