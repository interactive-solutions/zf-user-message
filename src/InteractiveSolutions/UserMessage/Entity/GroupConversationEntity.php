<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;

class GroupConversationEntity extends AbstractConversationEntity
{
    const TYPE = 'group';

    /**
     * GroupConversationEntity constructor.
     * @param array $participants
     */
    public function __construct(array $participants)
    {
        parent::__construct();

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        array_map(function(MessageUserInterface $u) {
            AbstractConversationEntity::addParticipant($this, $u);
        }, $participants);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
