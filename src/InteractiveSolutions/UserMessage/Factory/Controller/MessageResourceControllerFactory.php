<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\Factory\Controller;

use InteractiveSolutions\UserMessage\Controller\MessageResourceController;
use InteractiveSolutions\UserMessage\Entity\MessageEntity;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MessageResourceControllerFactory
 */
class MessageResourceControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return MessageResourceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = $serviceLocator->getServiceLocator();

        return new MessageResourceController(
            $sl->get('InteractiveSolutions\Message\ObjectManager')->getRepository(MessageEntity::class)
        );
    }
}
