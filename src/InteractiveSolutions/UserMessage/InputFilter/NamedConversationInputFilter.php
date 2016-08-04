<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\InputFilter;

use InteractiveSolutions\Stdlib\Validator\NoObjectExists;
use InteractiveSolutions\UserMessage\Entity\NamedConversationEntity;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;

final class NamedConversationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'name',
            'required'   => true,
            'validators' => [
                [
                    'name'    => NoObjectExists::class,
                    'options' => [
                        'fields'       => ['name'],
                        'entity_class' => NamedConversationEntity::class
                    ],
                ],
            ],
            'filters'    => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
        ]);
    }
}
