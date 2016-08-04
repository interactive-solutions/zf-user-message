<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\ConversationResourceController;
use InteractiveSolutions\UserMessage\Entity\AbstractConversationEntity;
use InteractiveSolutions\UserMessage\Repository\ConversationRepository;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ConversationResourceControllerFactory
 */
class ConversationResourceControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return ConversationResourceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = $serviceLocator->getServiceLocator();

        /**
         * @var ConversationRepository $conversationRepository
         */
        $conversationRepository = $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(AbstractConversationEntity::class);

        return new ConversationResourceController(
            $conversationRepository
        );
    }
}
