<?php

namespace ddd\Specification;

use ddd\Specification\AndSpecification;
use ddd\Specification\OrSpecification;
use ddd\Specification\NotSpecification;

/**
 * Represents any kind of specification.
 * 
 * @author ely
 */
interface Specification
{

    /**
     * Adds a "and" clause to a specification.
     * 
     * @param \ddd\Specification\Specification $specification The specification to add.
     * 
     * @return \ddd\Specification\AndSpecification The new specification.
     */
    public function and_(Specification $specification): AndSpecification;
    
    /**
     * Adds a "or" clause to a specification.
     * 
     * @param \ddd\Specification\Specification $specification The specification to add.
     * 
     * @return \ddd\Specification\OrSpecification The new specification.
     */
    public function or_(Specification $specification): OrSpecification;
    
    /**
     * Adds a "not" clause to a specification.
     * 
     * @param \ddd\Specification\Specification $specification The specification to add.
     * 
     * @return \ddd\Specification\NotSpecification The new specification.
     */
    public function not_(): NotSpecification;
    
    /**
     * Verifies if a specification is satisfied by an object.
     * 
     * @param mixed $value The value to test the specification with.
     * 
     * @return bool true if the specification is satisfied, false otherwise.
     */
    public function isSatisfiedBy($value): bool;

}
