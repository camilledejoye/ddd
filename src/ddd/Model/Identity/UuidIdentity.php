<?php

namespace ddd\Model\Identity;

use Ramsey\Uuid\Uuid;
use Assert\Assertion;

use ddd\Model\Identity\GeneratedIdentity;

/**
 * Represents an identity as a UUID.
 *
 * @author ely
 */
class UuidIdentity extends GeneratedIdentity
{

    /**
     * Generates a new identity.
     *
     * @return static The generated identity.
     */
    public static function generate()
    {
        $generator = function() {
            return Uuid::uuid4()->toString();
        };

        return parent::generateWith($generator);
    }
    
    /**
     * Creates a new identity from a string.
     * 
     * @param string $value The desired value for the identity, must be a valid UUID.
     * 
     * @return self The new identity.
     */
    public static function from($value)
    {
        Assertion::string($value);
        Assertion::uuid($value);
        
        return parent::from((string) $value);
    }

}
