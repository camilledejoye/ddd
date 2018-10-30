<?php

namespace ddd\Test\Specification;

use ddd\Specification\AndSpecification;
use PHPUnit\Framework\TestCase;
use ddd\Specification\Specification;

class AndSpecificationTest extends TestCase
{
    /**
     * @test
     * @dataProvider providesUnsatisfiedAndSpecification
     */
    public function thatItIsNotSatisfied(Specification $left, Specification $right)
    {
        $andSpecification = $left->andX($right);

        $this->assertFalse($andSpecification->isSatisfiedBy(null));
    }

    public function providesUnsatisfiedAndSpecification(): array
    {
        $trueSpecification  = new SpecificationMock(true);
        $falseSpecification = new SpecificationMock(false);

        return [
            'true && false'  => [$trueSpecification,  $falseSpecification],
            'false && true'  => [$falseSpecification, $trueSpecification],
            'false && false' => [$falseSpecification, $falseSpecification],
        ];
    }

    /**
     * @test
     */
    public function thatItIsSatisfied()
    {
        $andSpecification = (new SpecificationMock(true))->andX(new SpecificationMock(true));

        $this->assertTrue($andSpecification->isSatisfiedBy(null));
    }
}
