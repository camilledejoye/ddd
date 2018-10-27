<?php

namespace ddd\Test\Model\Identity;

use PHPUnit\Framework\TestCase;

use Ramsey\Uuid\Uuid;

use ddd\Model\Identity\Exception\InvalidUuidException;
use ddd\Model\Identity\UuidIdentity;

class UuidIdentityTest extends TestCase
{
    const UUID4 = 'cb146c26-84c5-43e0-a44e-5271129fa1fe';

    /**
     * @test
     */
    public function thatTheIdentityGeneratesAValidUuid()
    {
        $this->assertTrue(Uuid::isValid(UuidIdentity::generate()));
    }

    /**
     * @test
     */
    public function thatItGeneratesDifferentIdentities()
    {
        $id      = UuidIdentity::generate();
        $otherId = UuidIdentity::generate();

        $this->assertFalse($id->equals($otherId));
    }

    /**
     * @test
     */
    public function thatItCanCreateAnIdentityFromAValueWhichIsAnUuuid()
    {
        $this->assertInstanceOf(
            UuidIdentity::class,
            UuidIdentity::from(self::UUID4)
        );
    }

    /**
     * @test
     */
    public function thatItCantCreateAnIdentityFromAValueWhichIsNotAnUuid()
    {
        $this->expectException(InvalidUuidException::class);

        UuidIdentity::from('notAnUuid');
    }
}
