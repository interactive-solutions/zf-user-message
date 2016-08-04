<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Repository;

use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\NamedConversationNotFound;

interface NamedConversationRepositoryInterface extends ConversationRepositoryInterface
{
    /**
     * Get a named conversation by name
     *
     * @param string $slug
     *
     * @return NamedConversationEntity
     *
     * @throws NamedConversationNotFound
     */
    public function getBySlug(string $slug): NamedConversationEntity;
}
