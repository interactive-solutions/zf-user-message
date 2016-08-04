<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */
use InteractiveSolutions\UserMessage\Entity\ReadByUserEntry;

/* @var \InteractiveSolutions\UserMessage\Entity\MessageEntity $message */
$message = $this->message;

return [
    'id'             => $message->getId(),
    'conversationId' => $message->getConversation()->getId(),
    'senderId'       => $message->getSender()->getId(),

    'message'        => $message->getMessage(),

    'createdAt'      => $message->getCreatedAt()->format(DateTime::ISO8601),
    'updatedAt'      => $message->getUpdatedAt()->format(DateTime::ISO8601),
    
    'readByUsers'    => array_map(function(ReadByUserEntry $entry) {
        return [
            'userId' => $entry->getUserId(),
            'readAt' => $entry->getReadAt()->format(DateTime::ISO8601)
        ];
    }, $message->getReadByUsers())
];
