<?php

namespace ddd\Model\Identity;

use Ramsey\Uuid\Uuid;
use Assert\Assertion;

use ddd\Model\Identity\Identity;
use ddd\Model\Identity\GeneratedIdentity;

/**
 * Represents an identity as a UUID.
 *
 * @author cdejoye
 */
class UuidIdentity implements Identity
{

    /**
     * @var GeneratedIdentity
     */
    private $generatedId;
    
    /**
     * {@inheritdoc}
     */
    public static function generate()
    {
        return new static();
    }
    
    /**
     * {@inheritdoc}
     */
    public static function copy($idToCopy)
    {
        /* @var $idToCopy UuidIdentity */
        Assertion::isInstanceOf($idToCopy, static::class);
        
        $id = new static();
        
        $id->generatedId = GeneratedIdentity::copy($idToCopy->generatedId);
        
        return $id;
    }
    
    /**
     * {@inheritdoc}
     * 
     * @throws \InvalidArgumentException If the value is neither an integer a string or null.
     */
    public static function from($value)
    {
        Assertion::nullOrstring($value);
        Assertion::nullOruuid($value);
        
        $id = new static();
        
        $id->generatedId = GeneratedIdentity::from($value);
        
        return $id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->initialize();
    }
    
    /**
     * {@inheritdoc}
     */
    public function equals($value)
    {
        if (!($value instanceof static)) {
            return false;
        }

        return $value->generatedId->equals($this->generatedId);
    }
    
    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->generatedId->value();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->generatedId;
    }
    
    /**
     * Constructs an identity.
     */
    private function __construct()
    {
        $this->initialize();
    }

    /**
     * Initializes an identity.
     */
    private function initialize()
    {
        $generator = function() {
            return Uuid::uuid4();
        };
        
        $this->generatedId = GeneratedIdentity::generateWith($generator);
    }

}
