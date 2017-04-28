<?php

namespace ddd\Model\ValueObject;

use Ramsey\Uuid\Uuid;

use ddd\Model\ValueObject\EntityId;

/**
 * Represents an identity of an entity as a UUID.
 *
 * @author ely
 */
abstract class UuidEntityId implements EntityId
{

    /**
     * @var string The identity of the entity.
     */
    private $id;

    /**
     * Initializes an identity.
     *
     * @param self $id (optional) The already existing identity of the entity.
     */
    public function __construct(self $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->id = new static();
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo($value): bool
    {
        if (!$value instanceof static) {
            return false;
        }

        return $this->getId() === $value->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->id;
    }

}

