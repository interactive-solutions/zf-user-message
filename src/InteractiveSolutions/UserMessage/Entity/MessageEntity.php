<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;

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
     * @var MessageUserInterface
     */
    protected $sender;

    /**
     * @var AbstractConversationEntity
     */
    protected $conversation;

    /**
     * MessageEntity constructor.
     * @param AbstractConversationEntity $conversation
     * @param MessageUserInterface $sender
     * @param array $data
     */
    public function __construct(AbstractConversationEntity $conversation, MessageUserInterface $sender, array $data)
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->message      = $data['message'];
        $this->conversation = $conversation;
        $this->sender       = $sender;
    }

    /**
     * Add a ready by user entry
     *
     * @param MessageEntity $instance
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MessageUserInterface
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function getReadByUsers()
    {
        return $this->readByUsers;
    }

    /**
     * @return AbstractConversationEntity
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @param int $userId
     * @return bool
     */
    private function hasRead(int $userId):bool
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
