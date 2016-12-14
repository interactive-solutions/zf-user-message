<?php
/**
 * @author    Antoine Hedgecock <antoine.hedgecock@gmail.com>
 *
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Exception;

final class InvalidMessageException extends \RuntimeException implements ExceptionInterface
{
    public static function emptyMessageAndPayload(): self
    {
        return new self('Invalid message, either a message body or a payload must be specified');
    }
}
