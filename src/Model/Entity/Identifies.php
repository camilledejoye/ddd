<?php

declare(strict_types=1);

namespace ddd\Model\Entity;

/**
 * Interface for all objects that can be identified.
 *
 * @author cdejoye
 */
interface Identifies
{
    /**
     * @return mixed the identity of the object
     */
    public function id();
}
