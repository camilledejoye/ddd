<?php

namespace tests\ddd\Model\Identity;

use PHPUnit\Framework\TestCase;

use ddd\Model\Identity\Identity;

class IdentityTest extends TestCase
{
    
    /**
     * @test
     * 
     * @param int|string $value The value for the identity
     * 
     * @dataProvider provideValidIdentityValues
     */
    public function itCreatesAnIdentityFromAValue($value)
    {
        $id = Identity::from($value);
        
        $this->assertInstanceOf(Identity::class, $id);
        $this->assertEquals($value, $id->id());
    }
    
    public function provideValidIdentityValues()
    {
        return [
            [1],
            ['string'],
            [null],
        ];
    }
    
    /**
     * @test
     * 
     * @param mixed $value An invalid value.
     * 
     * @dataProvider provideInvalidIdentityValues
     */
    public function itFailsCreatingAnIdentityFromAValue($value)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        Identity::from($value);
    }
    
    public function provideInvalidIdentityValues()
    {
        // Doesn't test everything (like ressources)
        return [
            [1.1],
            [array()],
            [array(1)],
            [true],
            [new \stdClass()],
        ];
    }
    
    /**
     * @test
     */
    public function itCopiesAnIdentity()
    {
        $id       = Identity::from(1);
        $copiedId = Identity::copy($id);

        $this->assertTrue($id->equals($copiedId));
    }
    
    /**
     * @test
     */
    public function itClonesAnIdentity()
    {
        $id       = Identity::from(1);
        $clonedId = clone $id;

        $this->assertFalse($id->equals($clonedId));
    }

}

