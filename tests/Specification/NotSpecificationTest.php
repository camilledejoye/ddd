<?php

declare(strict_types=1);

namespace ddd\Test\Specification;

use PHPUnit\Framework\TestCase;

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
