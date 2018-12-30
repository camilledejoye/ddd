<?php

declare(strict_types=1);

namespace ddd\Model\Entity;

use ddd\Common\Equals;

/**
 * Represents an entity.
 *
 * @author cdejoye
 */
interface Entity extends Identifies, Equals
{
    /**
     * Gets the identity of an entity.
     *
     * @return \ddd\Model\Identity\Identity the identity of the entity
     */
    public function id();

    /**
     * Clones an entity.
     */
    public function __clone();
}
