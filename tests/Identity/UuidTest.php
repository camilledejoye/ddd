<?php

namespace ddd\Test\Identity;

use ddd\Identity\Exception\InvalidUuidStringException;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Identity\Uuid;
use Ramsey\Uuid\Uuid as BaseUuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    const UUID4 = 'cb146c26-84c5-43e0-a44e-5271129fa1fe';
    const NOT_A_UUID_STRING = 'not a UUID';

    /**
     * @var Uuid
     */
    private $sut;

    protected function setUp()
    {
        $this->sut = Uuid::fromString(self::UUID4);
    }

    /**
     * @test
     */
    public function shouldCreateAValidUuidFromAString()
    {
        $this->assertTrue(BaseUuid::isValid($this->sut));
    }

    /**
     * @test
     */
    public function shouldThrowAnExceptionWhenCreatingFromAStringWichIsNotAValidUuid()
    {
        $this->expectException(InvalidUuidStringException::class);
        $this->expectExceptionMessage(
            sprintf('The string "%s" is not a valid UUID.', self::NOT_A_UUID_STRING)
        );

        Uuid::fromString(self::NOT_A_UUID_STRING);
    }

    /**
     * @test
     */
    public function shouldGenerateAValidUuid()
    {
        $this->assertTrue(BaseUuid::isValid(Uuid::generate()));
    }

    /**
     * @test
     */
    public function shouldGenerateDifferentUuidEachTime()
    {
        $this->assertFalse(Uuid::generate()->equals(Uuid::generate()));
    }

    /**
     * @test
     * @dataProvider provideNotEqualsValues
     */
    public function shouldNotBeEqualsToSomethingFromAnotherType($other)
    {
        $this->assertFalse($this->sut->equals($other));
    }

    public function provideNotEqualsValues()
    {
        return [
            'The string representation of the UUID' => [self::UUID4],
            'Another type of identity' => [$this->getMockForAbstractClass(IdentifiesAnAggregate::class)],
            'A child identity with the same value' => [ChildUuid::fromString(self::UUID4)],
            'NULL' => [null],
        ];
    }

    /**
     * @test
     */
    public function shouldBeEqualsToItself()
    {
        $this->assertTrue($this->sut->equals($this->sut));
    }

    /**
     * @test
     */
    public function shouldTestTheEqualityOfInheritedTypesCorrectly()
    {
        $sut = ChildUuid::fromString(self::UUID4);
        $other = ChildUuid::fromString(self::UUID4);

        $this->assertTrue($sut->equals($other));
    }

    /**
     * @test
     */
    public function shouldReturnItsStringRepresentation()
    {
        $this->assertSame(self::UUID4, (string) $this->sut);
    }
}
