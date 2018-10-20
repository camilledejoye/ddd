<?php

namespace ddd\Model\Identity;

use PHPUnit\Framework\TestCase;

use ddd\Model\Identity\BasicIdentity;

class BasicIdentityTest extends TestCase
{
    
    /**
     * @test
     */
    public function itGeneratesANullIdentity()
    {
        $id = BasicIdentity::generate();
        
        $this->assertInstanceOf(BasicIdentity::class, $id);
        $this->assertNull($id->value());
    }
    
    /**
     * @test
     * 
     * @param int|string $value The value for the identity
     * 
     * @dataProvider provideValidIdentityValues
     */
    public function itCreatesAnIdentityFromAValue($value)
    {
        $id = BasicIdentity::from($value);
        
        $this->assertInstanceOf(BasicIdentity::class, $id);
        $this->assertEquals($value, $id->value());
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
        
        BasicIdentity::from($value);
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
            [''],
        ];
    }
    
    /**
     * @test
     */
    public function itCopiesAnIdentity()
    {
        $id       = BasicIdentity::from(1);
        $copiedId = BasicIdentity::copy($id);

        $this->assertTrue($id->equals($copiedId));
    }
    
    /**
     * @test
     */
    public function itClonesAnIdentity()
    {
        $id       = BasicIdentity::from(1);
        $clonedId = clone $id;

        $this->assertFalse($id->equals($clonedId));
    }

}

