<?php

namespace ddd\Utility;

use ddd\Utility\AndSpecification;
use ddd\Utility\OrSpecification;
use ddd\Utility\NotSpecification;

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
     * @param \ddd\Utility\Specification $specification The specification to add.
     * 
     * @return \ddd\Utility\AndSpecification The new specification.
     */
    public function and_(Specification $specification): AndSpecification;
    
    /**
     * Adds a "or" clause to a specification.
     * 
     * @param \ddd\Utility\Specification $specification The specification to add.
     * 
     * @return \ddd\Utility\OrSpecification The new specification.
     */
    public function or_(Specification $specification): OrSpecification;
    
    /**
     * Adds a "not" clause to a specification.
     * 
     * @param \ddd\Utility\Specification $specification The specification to add.
     * 
     * @return \ddd\Utility\NotSpecification The new specification.
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
