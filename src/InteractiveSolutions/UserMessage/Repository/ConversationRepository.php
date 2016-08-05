<?php
/**
 * @author    Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Entity\DirectConversationEntity;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use InteractiveSolutions\UserMessage\Repository\Exception\ConversationNotFound;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use Zend\Paginator\Paginator as ZendPaginator;

/**
 * Class ConversationRepository
 */
class ConversationRepository extends EntityRepository implements ConversationRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getById(int $id): AbstractConversationEntity
    {
        $conversation = $this->findOneBy(['id' => $id]);

        if (!$conversation) {
            throw new ConversationNotFound();
        }

        return $conversation;
    }

    /**
     * {@inheritdoc}
     */
    public function getConversationsWith(
        MessageUserInterface $user,
        MessageUserInterface $secondUser,
        Criteria $criteria = null
    ) {
        $builder = $this->createQueryBuilder('conversation')
            ->innerJoin('conversation.participants', 'participants', 'WITH', 'participants.id = :userId')
            ->innerJoin('conversation.participants', 'second', 'WITH', 'second = :secondUser')
            ->setParameter('userId', $user->getId())
            ->setParameter('secondUser', $secondUser);

        return new ZendPaginator(
            new DoctrinePaginator(
                new Paginator($builder->getQuery())
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConversationBetween(
        MessageUserInterface $user,
        MessageUserInterface $secondUser
    ): AbstractConversationEntity
    {
        $builder = $this->createQueryBuilder('conversation')
            ->innerJoin('conversation.participants', 'participants', 'WITH', 'participants.id = :userId')
            ->innerJoin('conversation.participants', 'second', 'WITH', 'second = :secondUser')
            ->andWhere('conversation.type = :type')
            ->setParameter('userId', $user->getId())
            ->setParameter('secondUser', $secondUser)
            ->setParameter('type', DirectConversationEntity::TYPE);

        $conversation = $builder->getQuery()->getOneOrNullResult();

        if (!$conversation) {
            throw new ConversationNotFound();
        }

        return $conversation;
    }

    public function getConversations(MessageUserInterface $user)
    {
        $builder = $this->createQueryBuilder('conversation')
            ->innerJoin('conversation.participants', 'participants', 'WITH', 'participants.id = :userId')
            ->setParameter('userId', $user->getId());

        return new ZendPaginator(
            new DoctrinePaginator(
                new Paginator($builder->getQuery())
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return new ZendPaginator(
            new DoctrinePaginator(
                new Paginator($this->createQueryBuilder('conversation')->getQuery())
            )
        );
    }
}
