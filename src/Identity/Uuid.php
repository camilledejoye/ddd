<?php

namespace ddd\Identity;

use Ramsey\Uuid\Uuid as BaseUuid;
use ddd\Identity\Exception\UuidException;
use ddd\Identity\Exception\InvalidUuidStringException;

class Uuid implements IdentifiesAnAggregate, GeneratesIdentities
{
    /**
     * @var BaseUuid
     */
    private $uuid;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidUuidStringException
     */
    public static function fromString(string $uuidAsAString)
    {
        if (!BaseUuid::isValid($uuidAsAString)) {
            throw UuidException::becauseAStringIsNotAValidUuid($uuidAsAString);
        }

        return new static(BaseUuid::fromString($uuidAsAString));
    }

    /**
     * Generates a Uuid.
     *
     * @return static
     */
    public static function generate()
    {
        return new static(BaseUuid::uuid4());
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other): bool
    {
        if (!\is_object($other)) {
            return false;
        }

        if (\get_class($this) !== \get_class($other)) {
            return false;
        }

        return $other->uuid->equals($this->uuid);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * Initializes an uuid.
     *
     * @param BaseUuid $uuid
     */
    private function __construct(BaseUuid $uuid)
    {
        $this->uuid = $uuid;
    }
}
