<?php

namespace ddd\Specification;

use ddd\Specification\Specification;

/**
 * A trait for all specification with one operand.
 *
 * @author cdejoye
 */
trait UnarySpecificationTrait
{
    /**
     * @var \ddd\Specification\Specification The left operand.
     */
    private $specification;

    /**
     * Initializes a specification.
     *
     * @param Specification $left  The left operand.
     * @param Specification $right The right operand.
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }
}
