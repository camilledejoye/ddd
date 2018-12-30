<?php

declare(strict_types=1);

namespace ddd\Common;

use ddd\Identity\IdentifiesAnAggregate;

interface RefersToAnAggregate
{
    /**
     * Gets the identity of the aggregate the object refers to.
     *
     * @return IdentifiesAnAggregate
     */
    public function aggregateId(): IdentifiesAnAggregate;
}
