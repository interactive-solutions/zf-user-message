<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Repository;

use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use InteractiveSolutions\UserMessage\Repository\Exception\NamedConversationNotFound;

final class NamedConversationRepository extends ConversationRepository implements NamedConversationRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBySlug(string $slug): NamedConversationEntity
    {
        $conversation = $this->findOneBy(['slug' => $slug]);

        if (!$conversation) {
            throw new NamedConversationNotFound();
        }

        return $conversation;
    }
}
