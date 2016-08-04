<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;

class ReadByUserEntry
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var DateTime
     */
    private $readAt;

    /**
     * ReadByUserEntry constructor.
     * @param int $userId
     * @param DateTime $readAt
     */
    public function __construct(int $userId, DateTime $readAt)
    {
        $this->userId = $userId;
        $this->readAt = $readAt;
    }

    /**
     * @return int
     */
    public function getUserId():int
    {
        return $this->userId;
    }

    /**
     * @return DateTime
     */
    public function getReadAt():DateTime
    {
        return $this->readAt;
    }
}
