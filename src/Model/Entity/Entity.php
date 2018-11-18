<?php

namespace ddd\Model\Entity;

use ddd\Common\Equals;

use ddd\Model\Entity\Identifies;

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
     * @return \ddd\Model\Identity\Identity The identity of the entity.
     */
    public function id();

    /**
     * Clones an entity.
     */
    public function __clone();
}
