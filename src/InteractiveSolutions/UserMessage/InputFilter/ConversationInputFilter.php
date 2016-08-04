<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\UserMessage\InputFilter;

use IsInteractiveSolutions\Stdlib\Validator\AllEntitiesExistsValidator;
use InteractiveSolutions\UserMessage\Entity\MessageUserInterface;
use Zend\InputFilter\InputFilter;

class ConversationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'participants',
            'required'   => true,
            'validators' => [
                [
                    'name'    => AllEntitiesExistsValidator::class ,
                    'options' => [
                        'entity_class' => MessageUserInterface::class,
                        'fields'       => ['id']
                    ]
                ]
            ]
        ]);
    }
}
