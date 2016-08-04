<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Entity;

use DateTime;
use InteractiveSolutions\UserMessage\Service\ConversationService;

final class NamedConversationEntity extends AbstractConversationEntity
{
    const TYPE = 'named';

    /**
     * NamedConversationEntity constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct();

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        $this->name = $data['name'];
        $this->slug = ConversationService::slugify($data['name']);
    }

    /**
     * Update the name of a conversation
     *
     * @param NamedConversationEntity $instance
     * @param array $data
     */
    public static function update(NamedConversationEntity $instance, array $data)
    {
        $instance->name = $data['name'];
        $instance->slug = ConversationService::slugify($data['name']);

        $instance->updatedAt = new DateTime();
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}
