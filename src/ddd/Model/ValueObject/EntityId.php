<?php

namespace ddd\Model\ValueObject;

/**
 * Represents an entity's identity.
 *
 * @author ely
 */
interface EntityId
{

    /**
     * Gets the identity of an entity.
     *
     * @return string The entity's identity.
     */
    public function getId(): string;

    /**
     * The string representation of an entity's identity.
     *
     * @return string The string representation of the identity.
     */
    public function __toString(): string;

    public function __clone();

}

