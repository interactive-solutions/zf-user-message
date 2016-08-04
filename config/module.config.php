<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use Doctrine\ORM\EntityManager;
use InteractiveSolutions\UserMessage\Controller\ConversationCollectionController;
use InteractiveSolutions\UserMessage\Controller\Conversation\MessageCollectionController as ConversationMessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\NamedConversation\MessageCollectionController as
    NamedConversationMessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\ConversationResourceController;
use InteractiveSolutions\UserMessage\Controller\ConversationRpcResource;
use InteractiveSolutions\UserMessage\Controller\MessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\MessageResourceController;
use InteractiveSolutions\UserMessage\Controller\MessageRpcResource;
use InteractiveSolutions\UserMessage\Controller\NamedConversationCollectionController;
use InteractiveSolutions\UserMessage\Controller\NamedConversationResourceController;
use InteractiveSolutions\UserMessage\Controller\NamedConversationRpcResource;
use InteractiveSolutions\UserMessage\Factory\Controller\ConversationCollectionControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\Conversation\MessageCollectionControllerFactory as
    ConversationMessageCollectionControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\NamedConversation\MessageCollectionControllerFactory as
    NamedConversationMessageCollectionControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\ConversationResourceControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\ConversationRpcResourceFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\MessageCollectionControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\MessageResourceControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\MessageRpcResourceFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\NamedConversationCollectionControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\NamedConversationResourceControllerFactory;
use InteractiveSolutions\UserMessage\Factory\Controller\NamedConversationRpcResourceFactory;
use InteractiveSolutions\UserMessage\Factory\Hydrator\ConversationHydratorFactory;
use InteractiveSolutions\UserMessage\Factory\Hydrator\MessageHydratorFactory;
use InteractiveSolutions\UserMessage\Factory\Service\ConversationServiceFactory;
use InteractiveSolutions\UserMessage\Factory\Service\MessageServiceFactory;
use InteractiveSolutions\UserMessage\Hydrator\ConversationHydrator;
use InteractiveSolutions\UserMessage\Hydrator\MessageHydrator;
use InteractiveSolutions\UserMessage\Hydrator\ParticipantsHydrator;
use InteractiveSolutions\UserMessage\InputFilter\MessageInputFilter;
use InteractiveSolutions\UserMessage\Service\ConversationService;
use InteractiveSolutions\UserMessage\Service\MessageService;

return [
    'router' => [
        'routes' => include __DIR__ . '/route.config.php',
    ],

    'doctrine' => include __DIR__ . '/doctrine.config.php',

    'controllers' => [
        'factories' => [
            MessageResourceController::class                    => MessageResourceControllerFactory::class,
            MessageCollectionController::class                  => MessageCollectionControllerFactory::class,
            ConversationResourceController::class               => ConversationResourceControllerFactory::class,
            ConversationCollectionController::class             => ConversationCollectionControllerFactory::class,
            ConversationMessageCollectionController::class      => ConversationMessageCollectionControllerFactory::class,
            NamedConversationMessageCollectionController::class => NamedConversationMessageCollectionControllerFactory::class,
            NamedConversationCollectionController::class        => NamedConversationCollectionControllerFactory::class,
            NamedConversationResourceController::class          => NamedConversationResourceControllerFactory::class,


            // Rpc
            NamedConversationRpcResource::class                 => NamedConversationRpcResourceFactory::class,
            ConversationRpcResource::class                      => ConversationRpcResourceFactory::class,
            MessageRpcResource::class                           => MessageRpcResourceFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            MessageService::class      => MessageServiceFactory::class,
            ConversationService::class => ConversationServiceFactory::class,
        ],

        'aliases' => [
            'InteractiveSolutions\Message\ObjectManager' => EntityManager::class,
        ],
    ],

    'hydrators' => [
        'factories'  => [
            MessageHydrator::class      => MessageHydratorFactory::class,
            ConversationHydrator::class => ConversationHydratorFactory::class,
        ],
        'invokables' => [
            ParticipantsHydrator::class => ParticipantsHydrator::class,
        ],
    ],

    'input_filters' => [
        'invokables' => [
            MessageInputFilter::class => MessageInputFilter::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'InteractiveSolutions\UserMessage' => __DIR__ . '/../view',
        ],
    ],
];
