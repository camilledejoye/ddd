<?php

namespace tests\ddd\Model\ValueObject;

use PHPUnit\Framework\TestCase;

use ddd\Model\ValueObject\UuidEntityId;

use tests\ddd\Model\ValueObject\TestId;

class UuidEntityIdTest extends TestCase
{

    /**
     * @var TestId
     */
    protected $id;

    protected function setUp()
    {
        $this->id = new TestId();
    }

    /**
     * @covers ddd\Model\ValueObject\UuidEntityId::__clone
     */
    public function test__clone()
    {
        $newId = clone $this->id;
        $this->assertNotSame((string) $this->id, (string) $newId);
    }

    /**
     * @covers ddd\Model\ValueObject\UuidEntityId::getId()
     */
    public function testGetId()
    {
        $sameId  = new TestId($this->id);
        $otherId = new TestId();

        $this->assertEquals($this->id->getId(), $sameId->getId());
        $this->assertNotEquals($this->id->getId(), $otherId->getId());
    }

    /**
     * @covers ddd\Model\ValueObject\UuidEntityId::__toString()
     */
    public function test__toString()
    {
        $this->assertNotEmpty((string) $this->id);
    }

    /**
     * @covers ddd\Model\ValueObject\UuidEntityId::equals
     */
    public function testIsEqualTo()
    {
        $sameId  = new TestId($this->id);
        $otherId = new TestId();

        $this->assertTrue($this->id->equals($sameId));
        $this->assertFalse($this->id->equals($otherId));
    }

}

