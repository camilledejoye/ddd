<?php

namespace ddd\Utility;

use ddd\Utility\Specification;

/**
 * A trait for all specification with one operand.
 * 
 * @author ely
 */
trait UnarySpecificationTrait
{

    /**
     * @var \ddd\Utility\Specification The left operand.
     */
    private $specification;
    
    /**
     * Initializes a specification.
     * 
     * @param Specification $left The left operand.
     * @param Specification $right The right operand.
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

}
