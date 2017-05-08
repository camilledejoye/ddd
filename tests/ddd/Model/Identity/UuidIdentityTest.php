<?php

namespace tests\ddd\Model\Identity;

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
     */
    public function itCreatesAnIdentityFromAValue()
    {
        $uuid = Uuid::uuid4()->toString();
        $id   = UuidIdentity::from($uuid);

        $this->assertValidIdentity($id);
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
    
    private function assertValidIdentity(UuidIdentity $id): bool
    {
        $assertInstanceOf = $this->assertInstanceOf(UuidIdentity::class, $id);
        $assertUuid       = $this->assertUuid($id->id());

        return $assertInstanceOf && $assertUuid;
    }
    
    /**
     * Taked from beberlei/assert
     */
    private function assertUuid($value): bool
    {
        $uuid = \str_replace(array('urn:', 'uuid:', '{', '}'), '', $value);

        return \preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $uuid);
    }

}

