<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Service;

use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;

interface ConversationServiceInterface
{
    /**
     * Create a conversation
     *
     * @param AbstractConversationEntity $conversation
     *
     * @return void
     */
    public function create(AbstractConversationEntity $conversation);

    /**
     * Update the name of a named conversation
     *
     * @param NamedConversationEntity $conversation
     *
     * @return void
     */
    public function update(NamedConversationEntity $conversation);

    /**
     * Adds a participant to the conversation
     *
     * @param AbstractConversationEntity   $conversation
     * @param MessageUserInterface $participant
     *
     * @return void
     */
    public function addParticipant(AbstractConversationEntity $conversation, MessageUserInterface $participant);

    /**
     * Removes a participant from the conversation
     *
     * @param AbstractConversationEntity   $conversation
     * @param MessageUserInterface $participant
     *
     * @return void
     */
    public function removeParticipant(AbstractConversationEntity $conversation, MessageUserInterface $participant);

    /**
     * Create a direct conversation between two people
     *
     * @param MessageUserInterface $identity
     * @param MessageUserInterface $target
     *
     * @return AbstractConversationEntity
     */
    public function createBetween(MessageUserInterface $identity, MessageUserInterface $target);
}
