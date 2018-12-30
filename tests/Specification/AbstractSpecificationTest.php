<?php

declare(strict_types=1);

namespace ddd\Test\Specification;

use PHPUnit\Framework\MockObject\MockObject;
use ddd\Specification\AbstractSpecification;
use PHPUnit\Framework\TestCase;
use ddd\Specification\AndSpecification;
use ddd\Specification\NotSpecification;
use ddd\Specification\OrSpecification;

class AbstractSpecificationTest extends TestCase
{
    /**
     * @var AbstractSpecification|MockObject
     */
    private $aSpecification;

    /**
     * @var AbstractSpecification|MockObject
     */
    private $anotherSpecification;

    protected function setUp()
    {
        $this->aSpecification = $this->getMockForAbstractClass(AbstractSpecification::class);
        $this->anotherSpecification = $this->getMockForAbstractClass(AbstractSpecification::class);
    }

    /**
     * @test
     */
    public function thatItCreatesAAndSpecifiction()
    {
        $this->assertInstanceOf(
            AndSpecification::class,
            $this->aSpecification->andX($this->anotherSpecification)
        );
    }

    /**
     * @test
     */
    public function thatItCreatesANotSpecifiction()
    {
        $this->assertInstanceOf(
            NotSpecification::class,
            $this->aSpecification->notX($this->anotherSpecification)
        );
    }

    /**
     * @test
     */
    public function thatItCreatesAOrSpecifiction()
    {
        $this->assertInstanceOf(
            OrSpecification::class,
            $this->aSpecification->orX($this->anotherSpecification)
        );
    }
}
