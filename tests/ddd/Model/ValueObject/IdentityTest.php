<?php

namespace tests\ddd\Model\ValueObject;

use PHPUnit\Framework\TestCase;

use ddd\Model\ValueObject\Identity;

class IdentityTest extends TestCase
{

    /**
     * @var Identity
     */
    protected $id;

    /**
     * @covers ddd\Model\ValueObject\Identity::getId()
     */
    public function test__construct()
    {
        $id      = new Identity(1);
        $sameId  = new Identity($id);
        $otherId = new Identity();
        
        $this->assertEquals(
            1,
            $id->getId()
        );
        
        $this->assertEquals(
            $id->getId(),
            $sameId->getId()
        );
        
        $this->assertEquals(
            null,
            $otherId->getId()
        );
    }

    /**
     * @covers ddd\Model\ValueObject\Identity::__clone
     * @depends test__construct
     */
    public function test__clone()
    {
        $id       = new Identity(1);
        $clonedId = clone $id;
        
        $this->assertEquals(
            null,
            $clonedId->getId()
        );
    }

    /**
     * @covers ddd\Model\ValueObject\Identity::__toString()
     * @depends test__construct
     */
    public function test__toString()
    {
        $id = new Identity(1);

        $this->assertEquals(
            '1',
            (string) $id
        );
    }

    /**
     * @covers ddd\Model\ValueObject\Identity::equals
     * @depends test__construct
     */
    public function testIsEqualTo()
    {
        $id      = new Identity(1);
        $sameId  = new Identity($id);
        $otherId = new Identity();

        $this->assertTrue($id->equals($sameId));
        
        $this->assertFalse($id->equals($otherId));
    }

}

