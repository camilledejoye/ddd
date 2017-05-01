<?php

namespace ddd\Model\Entity;

use ddd\Utility\Equals;

/**
 * Represents an entity.
 *
 * @author ely
 */
interface Entity extends Equals
{

    /**
     * Gets the identity of an entity.
     *
     * @return mixed The identity of the entity.
     */
    public function getId();

    /**
     * Clones an entity.
     */
    public function __clone();

}

