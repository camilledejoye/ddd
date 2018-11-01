<?php

namespace ddd\Model\Repository;

use ddd\Model\Entity\Entity;
use ddd\Model\Identity\Identity;

interface Repository
{
    /**
     * Find an entity from it's identity.
     *
     * @param Identity $id
     *
     * @return Entity
     */
    public function find(Identity $id);
}
