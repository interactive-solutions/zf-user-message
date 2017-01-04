<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;
use InteractiveSolutions\UserMessage\Exception\InvalidMessageException;

class MessageEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var Datetime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @var ReadByUserEntry[]
     */
    protected $readByUsers = [];

    /**
     * @var array|null
     */
    protected $payload;

    /**
     * @var MessageUserInterface
     */
    protected $sender;

    /**
     * @var AbstractConversationEntity
     */
    protected $conversation;

    /**
     * MessageEntity constructor.
     *
     * @param AbstractConversationEntity $conversation
     * @param MessageUserInterface       $sender
     * @param array                      $data
     */
    public function __construct(AbstractConversationEntity $conversation, MessageUserInterface $sender, array $data)
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->message = $data['message'] ?? '';
        $this->payload = $data['payload'] ?? null;

        if (strlen($this->message) === 0 && $this->payload === null) {
            throw InvalidMessageException::emptyMessageAndPayload();
        }

        $this->sender       = $sender;
        $this->conversation = $conversation;
    }

    /**
     * Add a ready by user entry
     *
     * @param MessageEntity   $instance
     * @param ReadByUserEntry $entry
     */
    public static function readByUser(MessageEntity $instance, ReadByUserEntry $entry)
    {
        if (!$instance->hasRead($entry->getUserId())) {
            $instance->readByUsers[] = $entry;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return MessageUserInterface
     */
    public function getSender(): ?MessageUserInterface
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array|null
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function getReadByUsers(): array
    {
        return $this->readByUsers;
    }

    /**
     * @return AbstractConversationEntity
     */
    public function getConversation(): AbstractConversationEntity
    {
        return $this->conversation;
    }

    /**
     * @param int $userId
     *
     * @return bool
     */
    private function hasRead(int $userId): bool
    {
        /* @var ReadByUserEntry $entry */
        foreach ($this->readByUsers as $entry) {
            if ($entry->getUserId() === $userId) {
                return true;
            }
        }

        return false;
    }
}
