<?php

namespace ddd\Test\Specification;

use ddd\Specification\AbstractSpecification;

/**
 * Description of SpecificationMock
 *
 * @author cdejoye
 */
class SpecificationMock extends AbstractSpecification
{
    private $result;

    public function __construct(bool $result)
    {
        $this->result = $result;
    }

    public function isSatisfiedBy($value): bool
    {
        return $this->result;
    }
}
