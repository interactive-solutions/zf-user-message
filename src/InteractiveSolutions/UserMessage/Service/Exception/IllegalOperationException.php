<?php
/**
 * @author    Antoine Hedgecock <antoine.hedgecock@gmail.com>
 *
 * @copyright Interactive Solutions AB
 */

namespace InteractiveSolutions\UserMessage\Service\Exception;

use DomainException;

class IllegalOperationException extends DomainException implements ExceptionInterface
{
    public static function editingParticipantsOnDirectConversation()
    {
        return new static('You are not allowed to edit participants in a direct conversation.');
    }
}
