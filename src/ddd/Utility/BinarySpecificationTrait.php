<?php

namespace ddd\Utility;

use ddd\Utility\Specification;

/**
 * A trait for all specification with two operands.
 * 
 * @author ely
 */
trait BinarySpecificationTrait
{

    /**
     * @var \ddd\Utility\Specification The left operand.
     */
    private $left;
    
    /**
     * @var \ddd\Utility\Specification The right operand.
     */
    private $right;
    
    /**
     * Initializes a specification.
     * 
     * @param Specification $left The left operand.
     * @param Specification $right The right operand.
     */
    public function __construct(Specification $left, Specification $right)
    {
        $this->left  = $left;
        $this->right = $right;
    }

}
