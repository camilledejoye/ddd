<?php

namespace ddd\Test\Specification;

use ddd\Specification\NotSpecification;
use PHPUnit\Framework\TestCase;
use ddd\Specification\Specification;

class NotSpecificationTest extends TestCase
{
    /**
     * @test
     */
    public function thatItIsSatisfied()
    {
        $notSpecification = (new SpecificationMock(false))->notX();

        $this->assertTrue($notSpecification->isSatisfiedBy(null));
    }

    /**
     * @test
     */
    public function thatItIsUnsatisfied()
    {
        $notSpecification = (new SpecificationMock(true))->notX();

        $this->assertFalse($notSpecification->isSatisfiedBy(null));
    }
}
