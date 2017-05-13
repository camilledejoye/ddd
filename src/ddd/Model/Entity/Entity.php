<?php

namespace ddd\Model\Entity;

use ddd\Utility\Equals;

/**
 * Represents an entity.
 *
 * @author cdejoye
 */
interface Entity extends Equals
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

