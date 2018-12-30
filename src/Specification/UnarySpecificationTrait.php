<?php

declare(strict_types=1);

namespace ddd\Specification;

/**
 * A trait for all specification with one operand.
 *
 * @author cdejoye
 */
trait UnarySpecificationTrait
{
    /**
     * @var \ddd\Specification\Specification the left operand
     */
    private $specification;

    /**
     * Initializes a specification.
     *
     * @param Specification $left  the left operand
     * @param Specification $right the right operand
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }
}
