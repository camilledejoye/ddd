<?php

namespace ddd\Test\Model\Identity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use ddd\Model\Identity\BasicIdentity;
use ddd\Model\Identity\Exception\IdentityValueException;
use ddd\Model\Identity\Identity;
use ddd\Utils\Equals;

class BasicIdentityTest extends TestCase
{
    const IDENTITY_VALUE = 'myIdentityValue';

    /**
     * @var BasicIdentity|MockObject
     */
    private $sut;

    protected function setUp()
    {
        $this->sut = BasicIdentity::from(self::IDENTITY_VALUE);
    }

    /**
     * @test
     * @dataProvider providesInvalidIdentityValues
     */
    public function thatItCantCreateAnIdentityFromAnInvalidValue($value)
    {
        $this->expectException(IdentityValueException::class);

        BasicIdentity::from($value);
    }

    public function providesInvalidIdentityValues()
    {
        return [
            'An empty string'                       => [''],
            'NULL'                                  => [null],
            'An object without __toString() method' => [new \StdClass()],
            'An array'                              => [[1, 2, 5, 49, 'fd']],
        ];
    }

    /**
     * @test
     * @dataProvider providesValuesEqualsToTheSut
     */
    public function thatAnIdentityEqualsAValue($value)
    {
        $this->assertTrue($this->sut->equals($value));
    }

    public function providesValuesEqualsToTheSut()
    {
        $equalsImplementation = $this->createMock(Equals::class);
        $equalsImplementation->expects($this->once())
            ->method('equals')
            ->with($this->identicalTo(self::IDENTITY_VALUE))
            ->willReturn(true);

        return [
            'The identity value'                                               => [self::IDENTITY_VALUE],
            'Any objects implementing Equals and for which equals return true' => [$equalsImplementation],
        ];
    }
}
