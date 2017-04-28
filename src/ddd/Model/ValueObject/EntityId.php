<?php

namespace ddd\Model\ValueObject;

use ddd\Utility\ComparesTo;

/**
 * Represents an entity's identity.
 *
 * @author ely
 */
interface EntityId extends ComparesTo
{

    /**
     * Clones an identity
     */
    public function __clone();

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

}

