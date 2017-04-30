<?php

namespace ddd\Model\ValueObject;

use ddd\Utility\Equals;

/**
 * Represents an identity.
 * 
 * @author ely
 */
class Identity implements Equals
{
    
    /**
     * @var mixed The identity of the entity.
     */
    protected $id;

    /**
     * Initializes an identity.
     *
     * @param self $id The desired value.
     */
    public function __construct($id = null)
    {
        if ($id instanceof static) {
            $this->id = $id->id;
        } else {
            $this->id = $id;
        }
    }

    /**
     * Clones an identity
     */
    public function __clone()
    {
        $this->id = null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function equals($value): bool
    {
        if (!$value instanceof static) {
            return false;
        }

        return $this->getId() === $value->getId();
    }
    
    /**
     * Gets the identity of an entity.
     *
     * @return mixed The entity's identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The string representation of an entity's identity.
     *
     * @return string The string representation of the identity.
     */
    public function __toString(): string
    {
        return (string) $this->id;
    }

}

