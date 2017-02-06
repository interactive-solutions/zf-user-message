<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Service;


use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;

interface MessageServiceInterface
{
    /**
     * Creates a message
     *
     * @param MessageEntity $message
     * @return void
     */
    public function create(MessageEntity $message);

    /**
     * Updates a message
     *
     * @param MessageEntity $messageEntity
     * @return void
     */
    public function update(MessageEntity $messageEntity);

    /**
     * Marks a message as read by a user
     *
     * @param MessageEntity $message
     * @param MessageUserInterface $user
     * @return void
     */
    public function markAsReadByUser(MessageEntity $message, MessageUserInterface $user);
}
