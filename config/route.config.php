<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use InteractiveSolutions\UserMessage\Controller\Conversation\MessageCollectionController as ConversationMessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\NamedConversation\MessageCollectionController as
    NamedConversationMessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\ConversationCollectionController;
use InteractiveSolutions\UserMessage\Controller\ConversationResourceController;
use InteractiveSolutions\UserMessage\Controller\ConversationRpcResource;
use InteractiveSolutions\UserMessage\Controller\MessageCollectionController;
use InteractiveSolutions\UserMessage\Controller\MessageResourceController;
use InteractiveSolutions\UserMessage\Controller\MessageRpcResource;
use InteractiveSolutions\UserMessage\Controller\NamedConversationCollectionController;
use InteractiveSolutions\UserMessage\Controller\NamedConversationResourceController;
use InteractiveSolutions\UserMessage\Controller\NamedConversationRpcResource;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [

    'named-conversations' => [
        'type'          => Literal::class,
        'options'       => [
            'route'    => '/named-conversations',
            'defaults' => [
                'controller' => NamedConversationCollectionController::class,
            ],
        ],
        'may_terminate' => true,
        'child_routes'  => [
            'resource' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/:slug',
                    'defaults' => [
                        'controller' => NamedConversationResourceController::class,
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'rpc' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:action',
                            'defaults' => [
                                'controller' => NamedConversationRpcResource::class
                            ],
                            'constraints' => [
                                'action' => '(add-participant|remove-participant)'
                            ]
                        ]
                    ],
                    'messages' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/messages',
                            'defaults' => [
                                'controller' => NamedConversationMessageCollectionController::class
                            ]
                        ]
                    ]
                ]
            ],
        ],
    ],

    'conversations' => [
        'type'          => Literal::class,
        'options'       => [
            'route'    => '/conversations',
            'defaults' => [
                'controller' => ConversationCollectionController::class,
            ],
        ],
        'may_terminate' => true,
        'child_routes'  => [
            'load' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/load',
                    'defaults' => [
                        'controller' => ConversationRpcResource::class,
                        'action'     => 'load',
                    ],
                ],
            ],

            'resource' => [
                'type'          => Segment::class,
                'options'       => [
                    'route'       => '/:conversation_id',
                    'defaults'    => [
                        'controller' => ConversationResourceController::class,
                    ],
                    'constraints' => [
                        'conversation_id' => '\d+',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'messages' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/messages',
                            'defaults' => [
                                'controller' => ConversationMessageCollectionController::class,
                            ],
                        ],
                    ],
                    'rpc'      => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/:action',
                            'defaults'    => [
                                'controller' => ConversationRpcResource::class,
                            ],
                            'constraints' => [
                                'action' => '(add-participant|remove-participant)',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'messages' => [
        'type'          => Literal::class,
        'options'       => [
            'route'    => '/messages',
            'defaults' => [
                'controller' => MessageCollectionController::class,
            ],
        ],
        'may_terminate' => true,
        'child_routes'  => [
            'resource' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/:message_id',
                    'defaults' => [
                        'controller' => MessageResourceController::class,
                    ],
                ],

                'may_terminate' => true,
                'child_routes'  => [
                    'rpc' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/:action',
                            'defaults'    => [
                                'controller' => MessageRpcResource::class,
                            ],
                            'constraints' => [
                                'action' => 'read',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
