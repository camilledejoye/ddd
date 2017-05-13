<?php

namespace ddd\Specification;

use ddd\Specification\AbstractSpecification;

/**
 * A specification that requires at least one of two others
 * to be right in order to be satisfied.
 *
 * @author cdejoye
 */
final class OrSpecification extends AbstractSpecification
{

    use BinarySpecificationTrait;
    
    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($value): bool
    {
        return $this->left->isSatisfiedBy($value)
            || $this->right->isSatisfiedBy($value);
    }

}
