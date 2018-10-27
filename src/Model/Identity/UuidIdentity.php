<?php

namespace ddd\Model\Identity;

use Ramsey\Uuid\Uuid;
use ddd\Model\Identity\Exception\InvalidUuidException;

/**
 * Represents an identity as a UUID.
 *
 * @author cdejoye
 */
class UuidIdentity extends BasicIdentity implements SelfGeneratedIdentity
{
    /**
     * {@inheritdoc}
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * {@inheritdoc}
     */
    public static function from($value)
    {
        static::assertThatAStringIsAValidUuid($value);

        return parent::from($value);
    }

    /**
     * Asserts that a value is a valid UUID.
     *
     * @param string $value
     *
     * @return void
     */
    protected static function assertThatAStringIsAValidUuid(string $value): void
    {
        if (!Uuid::isValid($value)) {
            InvalidUuidException::becauseItsNotAValidUuid($value);
        }
    }
}
