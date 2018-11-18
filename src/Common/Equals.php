<?php

namespace ddd\Common;

/**
 * Represents objects that can be compared to something.
 *
 * @author cdejoye
 */
interface Equals
{
    /**
     * Compares a value to know if it is equal to an object.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function equals($value): bool;
}
