<?php

namespace ddd\Utility;

/**
 * Represents objects that can be compared to something.
 *
 * @author ely
 */
interface Equals
{

    /**
     * Compares a value to know if it is equal to an object.
     * 
     * @param mixed $value The value to compare with.
     * @return boolean true if the value and the object are equal, false otherwise.
     */
    public function equals($value): bool;

}

