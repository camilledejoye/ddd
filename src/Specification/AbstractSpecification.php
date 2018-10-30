<?php

namespace ddd\Specification;

use ddd\Specification\AndSpecification;
use ddd\Specification\OrSpecification;
use ddd\Specification\NotSpecification;

/**
 * A base for all Specification objects.
 *
 * @author cdejoye
 */
abstract class AbstractSpecification implements Specification
{
    /**
     * {@inheritdoc}
     */
    public function andX(Specification $specification)
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function orX(Specification $specification)
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function notX()
    {
        return new NotSpecification($this);
    }
}
