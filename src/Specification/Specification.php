<?php

namespace ddd\Specification;

/**
 * Represents any kind of specification.
 *
 * @author cdejoye
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
    public function andX(Specification $specification);

    /**
     * Adds a "or" clause to a specification.
     *
     * @param \ddd\Specification\Specification $specification The specification to add.
     *
     * @return \ddd\Specification\OrSpecification The new specification.
     */
    public function orX(Specification $specification);

    /**
     * Adds a "not" clause to a specification.
     *
     * @param \ddd\Specification\Specification $specification The specification to add.
     *
     * @return \ddd\Specification\NotSpecification The new specification.
     */
    public function notX();

    /**
     * Verifies if a specification is satisfied by an object.
     *
     * @param mixed $value The value to test the specification with.
     *
     * @return bool true if the specification is satisfied, false otherwise.
     */
    public function isSatisfiedBy($value): bool;
}
