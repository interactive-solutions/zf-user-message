<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractConversationEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Datetime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @var MessageUserInterface
     */
    protected $participants;

    /**
     * @var MessageEntity[]
     */
    protected $messages;

    /**
     * AbstractConversationEntity constructor.
     */
    public function __construct()
    {
        $this->messages     = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    /**
     * @param AbstractConversationEntity $instance
     * @param MessageUserInterface $participant
     */
    public static function addParticipant(AbstractConversationEntity $instance, MessageUserInterface $participant)
    {
        if (!$instance->participants->contains($participant)) {
            $instance->participants->add($participant);
        }
    }

    /**
     * @param AbstractConversationEntity $instance
     * @param MessageUserInterface $participant
     */
    public static function removeParticipant(AbstractConversationEntity $instance, MessageUserInterface $participant)
    {
        if ($instance->participants->contains($participant)) {
            $instance->participants->removeElement($participant);
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
     * @return MessageUserInterface[]|Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return MessageEntity[]|ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
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
     * Get conversation type
     *
     * @return string
     */
    public abstract function getType(): string;
}
