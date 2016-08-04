<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use Doctrine\Common\Collections\Criteria;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use Zend\Stdlib\ArrayUtils;

/* @var AbstractConversationEntity $conversation */
$conversation = $this->conversation;

$criteria = Criteria::create();
$criteria->orderBy(['id' => 'desc']);
$criteria->setMaxResults(20);

$messages = $conversation->getMessages()->matching($criteria);

return [
    'id'             => $conversation->getId(),
    'createdAt'      => $conversation->getCreatedAt()->format(DateTime::ISO8601),
    'type'           => $conversation->getType(),

    'latestMessages' => array_map(function(MessageEntity $message) {
        return [
            'id'        => $message->getId(),
            'message'   => $message->getMessage(),
            'createdAt' => $message->getCreatedAt()->format(DateTime::ISO8601),
            'author'    => $message->getSender()->getId(),
        ];
    }, ArrayUtils::iteratorToArray($messages)),

    'participants'   => array_map(function(MessageUserInterface $participant) {
        /* @var MessageUserInterface $participant */
        return $participant->getId();
    }, ArrayUtils::iteratorToArray($conversation->getParticipants()))
];
