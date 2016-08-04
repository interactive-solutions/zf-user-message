<?php
/**
 * @author    Antoine Hedgecock <antoine.hedgecock@gmail.com>
 *
 * @copyright Interactive Solutions AB
 */

namespace InteractiveSolutions\UserMessage\Event;

use Zend\EventManager\Event;

class ConversationEvent extends Event
{
    const CREATED = 'is:user-message:conversation:created';
    const UPDATED = 'is:user-message:conversation:updated';

    const PARTICIPANT_ADDED = 'is:user-message:conversation:participant:added';
    const PARTICIPANT_REMOVED = 'is:user-message:conversation:participant:removed';
}
