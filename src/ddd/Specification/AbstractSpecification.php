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
    public function and_(Specification $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function or_(Specification $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function not_(): NotSpecification
    {
        return new NotSpecification($this);
    }

}
