<?php

namespace ddd\Model\Identity;

use PHPUnit\Framework\TestCase;

use Ramsey\Uuid\Uuid;

use ddd\Model\Identity\UuidIdentity;

class UuidIdentityTest extends TestCase
{
    
    /**
     * @test
     */
    public function itGeneratesIdentity()
    {
        $id = UuidIdentity::generate();
        
        $this->assertValidIdentity($id);
    }
    
    /**
     * @test
     */
    public function itGeneratesDifferentIdentities()
    {
        $id      = UuidIdentity::generate();
        $otherId = UuidIdentity::generate();

        $this->assertFalse($id->equals($otherId));
    }
    
    /**
     * @test
     * 
     * @param null|string $value The value for the identity
     * 
     * @dataProvider provideValidIdentityValues
     */
    public function itCreatesAnIdentityFromAValue($value)
    {
        $id = UuidIdentity::from($value);

        $this->assertValidIdentity($id);
    }
    
    public function provideValidIdentityValues()
    {
        return [
            [Uuid::uuid4()->toString()],
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
        
        UuidIdentity::from($value);
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
            [1],
            ['string'],
            [''],
        ];
    }
    
    /**
     * @test
     */
    public function itCopiesAnIdentity()
    {
        $id       = UuidIdentity::generate();
        $copiedId = UuidIdentity::copy($id);
        
        $this->assertTrue($id->equals($copiedId));
    }
    
    /**
     * @test
     */
    public function itClonesAnIdentity()
    {
        $id       = UuidIdentity::generate();
        $clonedId = clone $id;
        
        $this->assertFalse($id->equals($clonedId));
    }
    
    /**
     * @test
     */
    public function itFailesComparingTwoIdentity()
    {
        $uuid = UuidIdentity::generate();
        $generatedId = GeneratedIdentity::generate();
        
        $this->assertFalse($uuid->equals($generatedId)); // To test UuidIdentity::equals
        $this->assertFalse($generatedId->equals($uuid)); // To test BasicIdentity::equals
    }
    
    private function assertValidIdentity(UuidIdentity $id)
    {
        $this->assertInstanceOf(UuidIdentity::class, $id);
        
        if (null !== $id->value()) {
            $this->assertUuid($id->value());
        }
    }
    
    /**
     * Taked from beberlei/assert
     */
    private function assertUuid($value)
    {
        $uuid = \str_replace(array('urn:', 'uuid:', '{', '}'), '', $value);

        $this->assertRegExp(
            '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/',
            $uuid,
            sprintf(
                'Failed asserting that \'%s\' is a valid UUID.',
                $value
        ));
    }

}

