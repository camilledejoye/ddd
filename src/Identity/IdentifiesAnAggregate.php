<?php

namespace ddd\Identity;

use ddd\Common\Equals;

interface IdentifiesAnAggregate extends Equals
{
    /**
     * Creates an identity from a string representation.
     *
     * @param string $value
     *
     * @return static
     */
    public static function fromString(string $value);

    /**
     * Returns the string representatio of the identity.
     *
     * @return string
     */
    public function __toString(): string;
}
