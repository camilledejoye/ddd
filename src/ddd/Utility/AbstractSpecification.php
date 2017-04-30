<?php

namespace ddd\Utility;

use ddd\Utility\AndSpecification;
use ddd\Utility\OrSpecification;
use ddd\Utility\NotSpecification;

/**
 * A base for all Specification objects.
 *
 * @author ely
 */
abstract class AbstractSpecification implements Specification
{
 
    /**
     * {@inheritdoc}
     */
    public function andSpec(Specification $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function orSpec(Specification $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * {@inheritdoc}
     */
    public function notSpec(): NotSpecification
    {
        return new NotSpecification($this);
    }

}
