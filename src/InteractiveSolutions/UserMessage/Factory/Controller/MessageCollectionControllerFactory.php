<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;


use InteractiveSolutions\UserMessage\Controller\MessageCollectionController;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MessageCollectionControllerFactory
 */
class MessageCollectionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return MessageCollectionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = $serviceLocator->getServiceLocator();

        return new MessageCollectionController(
            $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class)
        );
    }
}
