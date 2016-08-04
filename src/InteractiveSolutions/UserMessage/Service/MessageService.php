<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Service;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Entity\ReadByUserEntry;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;

/**
 * Class MessageService
 */
class MessageService implements EventManagerAwareInterface, MessageServiceInterface
{
    use EventManagerAwareTrait;

    const EVENT_CREATED      = 'InteractiveSolutions\UserMessage\Service\MessageService::create';
    const EVENT_READ_BY_USER = 'InteractiveSolutions\UserMessage\Service\MessageService::readByUser';

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create a new message
     *
     * @param MessageEntity $messageEntity
     */
    public function create(MessageEntity $messageEntity)
    {
        $this->objectManager->persist($messageEntity);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(self::EVENT_CREATED, $this, ['message' => $messageEntity]);
    }

    /**
     * @param MessageEntity $messageEntity
     */
    public function update(MessageEntity $messageEntity)
    {
        $this->objectManager->flush();
    }

    public function markAsReadByUser(MessageEntity $message, MessageUserInterface $user)
    {
        MessageEntity::readByUser($message, new ReadByUserEntry($user->getId(), new DateTime()));

        $this->objectManager->flush();

        $this->getEventManager()->trigger(self::EVENT_READ_BY_USER, $this, ['message' => $message]);
    }
}
