<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @author Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\InputFilter;

use InteractiveSolutions\Stdlib\Validator\ObjectExists;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Callback;
use Zend\Validator\StringLength;

/**
 * Class MessageInputFilter
 */
class MessageInputFilter extends InputFilter
{
    public function init()
    {
        $this->add(
            [
                'name'       => 'message',
                'required'   => true,
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'min' => 1,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'payload',
                'required'   => false,
                'validators' => [
                    [
                        'name'    => Callback::class,
                        'options' => [
                            'callback' => function ($value) {
                                return is_array($value);
                            },
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'sender',
                'required'   => false,
                'validators' => [
                    [
                        'name'    => ObjectExists::class,
                        'options' => [
                            'fields'       => ['id'],
                            'entity_class' => MessageUserInterface::class,
                        ],
                    ],
                ],
            ]
        );
    }
}
