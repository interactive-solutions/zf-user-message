<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;

final class DirectConversationEntity extends AbstractConversationEntity
{
    const TYPE = 'direct';

    /**
     * DirectConversationEntity constructor.
     * @param array $participants
     * @param array $data
     */
    public function __construct(array $participants, array $data)
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
