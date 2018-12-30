<?php

declare(strict_types=1);

namespace ddd\Specification;

/**
 * A trait for all specification with two operands.
 *
 * @author cdejoye
 */
trait BinarySpecificationTrait
{
    /**
     * @var \ddd\Specification\Specification the left operand
     */
    private $left;

    /**
     * @var \ddd\Specification\Specification the right operand
     */
    private $right;

    /**
     * Initializes a specification.
     *
     * @param Specification $left  the left operand
     * @param Specification $right the right operand
     */
    public function __construct(Specification $left, Specification $right)
    {
        $this->left = $left;
        $this->right = $right;
    }
}
