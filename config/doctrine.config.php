<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

use InteractiveSolutions\UserMessage\Infrastructure\Doctrine\Type\ReadByUsersType;

return [
    'driver' => [
        'InteractiveSolutions_user_message_driver' => [
            'class'     => Doctrine\ORM\Mapping\Driver\XmlDriver::class,
            'paths'     => [
                'default' => __DIR__ . '/doctrine',
            ]
        ],

        'orm_default' => [
            'drivers' => [
                'InteractiveSolutions\UserMessage\Entity' => 'InteractiveSolutions_user_message_driver'
            ]
        ]
    ],

    'configuration' => [
        'orm_default' => [
            'types' => [
                'read_by_users' => ReadByUsersType::class
            ]
        ]
    ]
];
