<?php

namespace ddd\Model\Identity;

use ddd\Utils\Equals;

/**
 * Represents an identity.
 *
 * @author cdejoye
 */
interface Identity extends Equals
{
    /**
     * Gets the value of an identity.
     *
     * @return mixed
     */
    public function value();

    /**
     * The value of the identity.
     *
     * @return string
     */
    public function __toString(): string;
}
