<?php

namespace tests\ddd\Utility;

use ddd\Utility\AbstractSpecification;

/**
 * Description of SpecificationMock
 *
 * @author ely
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
