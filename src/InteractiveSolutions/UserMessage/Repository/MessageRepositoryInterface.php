<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Repository;

use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use Zend\Paginator\Paginator;

interface MessageRepositoryInterface
{
    /**
     * Retrieve a message by id
     *
     * @param int $id
     * @return null|MessageEntity
     */
    public function getById(int $id): MessageEntity;

    /**
     * Get messages associated with a user
     *
     * @param MessageUserInterface $user
     * @return Paginator
     */
    public function getMessagesAssociatedWith(MessageUserInterface $user);

    /**
     * Gets all messages associated with a conversation
     *
     * @param AbstractConversationEntity $conversation
     * @return Paginator
     */
    public function getByConversation(AbstractConversationEntity $conversation);
}
