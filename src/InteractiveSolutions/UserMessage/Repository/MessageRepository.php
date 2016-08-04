<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use Zend\Paginator\Paginator as ZendPaginator;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;

/**
 * Class MessageRepository
 */
class MessageRepository extends EntityRepository implements MessageRepositoryInterface
{
    public function getById(int $id): MessageEntity
    {
        $message = $this->findOneBy(['id' => $id]);

        if (!$message) {

        }
    }

    public function getMessagesAssociatedWith(MessageUserInterface $user)
    {
        $builder = $this->createQueryBuilder('messages');
        $builder->leftJoin('messages.conversation', 'conversation')
            ->leftJoin('conversation.participants', 'participants')
            ->andWhere($builder->expr()->in('participants', [$user->getId()]))
            ->orderBy('messages.createdAt', 'DESC');

        return new ZendPaginator(
            new DoctrinePaginator(
                new Paginator($builder->getQuery())
            )
        );
    }

    public function getByConversation(AbstractConversationEntity $conversation)
    {
        $builder = $this->createQueryBuilder('messages');

        $builder
            ->leftJoin('messages.conversation', 'conversation')
            ->andWhere($builder->expr()->eq('conversation.id', ':conversationId'))
            ->orderBy('messages.createdAt', 'DESC')
            ->setParameter('conversationId', $conversation->getId());

        return new ZendPaginator(
            new DoctrinePaginator(
                new Paginator($builder->getQuery())
            )
        );
    }
}
