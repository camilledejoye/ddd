<?php

namespace ddd\Specification;

use ddd\Specification\AbstractSpecification;

/**
 * A specification that requires another one to be wrong
 * in order to be satisfied.
 *
 * @author cdejoye
 */
final class NotSpecification extends AbstractSpecification
{

    use UnarySpecificationTrait;
    
    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($value): bool
    {
        return false === $this->specification->isSatisfiedBy($value);
    }

}
