<?php
/**
 * @author    Antoine Hedgecock <antoine.hedgecock@gmail.com>
 *
 * @copyright Interactive Solutions
 */

declare(strict_types = 1);

namespace InteractiveSolutions\UserMessage\Infrastructure\Doctrine\Type;


use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InteractiveSolutions\UserMessage\Entity\ReadByUserEntry;

final class ReadByUsersType extends Type
{
    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $data = [];

        /* @var $entry ReadByUserEntry */
        foreach ($value as $entry) {
            $data[] = [$entry->getUserId(), $entry->getReadAt()->getTimestamp()];
        }

        return json_encode($data);
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $data = [];

        foreach (json_decode($value, true) as $entry) {
            $data[] = new ReadByUserEntry($entry[0], DateTime::createFromFormat('U', (string) $entry[1]));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }


    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'read_by_users';
    }
}
