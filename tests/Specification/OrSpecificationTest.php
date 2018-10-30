<?php

namespace ddd\Test\Specification;

use ddd\Specification\OrSpecification;
use PHPUnit\Framework\TestCase;
use ddd\Specification\Specification;

class OrSpecificationTest extends TestCase
{
    /**
     * @test
     * @dataProvider providesSatisfiedOrSpecification
     */
    public function thatItIsSatisfied(Specification $left, Specification $right)
    {
        $orSpecification = $left->orX($right);

        $this->assertTrue($orSpecification->isSatisfiedBy(null));
    }

    public function providesSatisfiedOrSpecification(): array
    {
        $trueSpecification  = new SpecificationMock(true);
        $falseSpecification = new SpecificationMock(false);

        return [
            'true && true'  => [$trueSpecification,  $trueSpecification],
            'true && false' => [$trueSpecification,  $falseSpecification],
            'false && true' => [$falseSpecification, $trueSpecification],
        ];
    }

    /**
     * @test
     */
    public function thatItIsUnsatisfied()
    {
        $orSpecification = (new SpecificationMock(false))->orX(new SpecificationMock(false));

        $this->assertFalse($orSpecification->isSatisfiedBy(null));
    }
}
