<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Repository;

use Doctrine\Common\Collections\Criteria;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\Exception\ConversationNotFound;
use Zend\Paginator\Paginator;

interface ConversationRepositoryInterface
{
    /**
     * Retrieves a conversation by id
     *
     * @param int $id
     *
     * @return AbstractConversationEntity
     *
     * @throws ConversationNotFound
     */
    public function getById(int $id): AbstractConversationEntity;

    /**
     * Retrieves all conversations
     *
     * @return Paginator
     */
    public function getAll();

    /**
     * Retrieves all conversations between two users
     *
     * @param MessageUserInterface $user
     * @param MessageUserInterface $secondUser
     * @param Criteria             $criteria
     *
     * @return Paginator
     */
    public function getConversationsWith(
        MessageUserInterface $user,
        MessageUserInterface $secondUser,
        Criteria $criteria = null
    );

    /**
     * Get a direct conversation between two users
     *
     * @param MessageUserInterface $user
     * @param MessageUserInterface $secondUser
     *
     * @return AbstractConversationEntity
     *
     * @throws ConversationNotFound
     */
    public function getConversationBetween(
        MessageUserInterface $user,
        MessageUserInterface $secondUser
    ): AbstractConversationEntity;
}
