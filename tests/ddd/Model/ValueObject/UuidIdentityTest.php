<?php

namespace tests\ddd\Model\ValueObject;

use PHPUnit\Framework\TestCase;

use ddd\Model\ValueObject\UuidIdentity;

class UuidIdentityTest extends TestCase
{

    /**
     * @var UuidIdentity
     */
    protected $id;

    protected function setUp()
    {
        $this->id = new UuidIdentity();
    }

    /**
     * @covers ddd\Model\ValueObject\UuidIdentity::__clone
     */
    public function test__clone()
    {
        $newId = clone $this->id;
        $this->assertNotSame((string) $this->id, (string) $newId);
    }

    /**
     * @covers ddd\Model\ValueObject\UuidIdentity::getId()
     */
    public function testGetId()
    {
        $sameId  = new UuidIdentity($this->id);
        $otherId = new UuidIdentity();

        $this->assertEquals($this->id->getId(), $sameId->getId());
        $this->assertNotEquals($this->id->getId(), $otherId->getId());
    }

    /**
     * @covers ddd\Model\ValueObject\UuidIdentity::__toString()
     */
    public function test__toString()
    {
        $this->assertNotEmpty((string) $this->id);
    }

    /**
     * @covers ddd\Model\ValueObject\UuidIdentity::equals
     */
    public function testIsEqualTo()
    {
        $sameId  = new UuidIdentity($this->id);
        $otherId = new UuidIdentity();

        $this->assertTrue($this->id->equals($sameId));
        $this->assertFalse($this->id->equals($otherId));
    }

}

