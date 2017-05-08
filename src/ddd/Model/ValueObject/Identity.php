<?php

namespace ddd\Model\ValueObject;

use Assert\Assertion;
use Assert\LazyAssertionException;

use ddd\Utility\Equals;

/**
 * Represents an identity.
 * 
 * @author ely
 */
class Identity implements Equals
{
    
    /**
     * @var mixed The identity of the entity.
     */
    protected $id;
    
    /**
     * Creates a new identity from another one.
     * 
     * @param static $idToCopy The identity to copy.
     * 
     * @return static The new identity.
     */
    public static function copy($idToCopy)
    {
        Assertion::isInstanceOf($idToCopy, static::class);
        
        $id = new static();
        
        $id->id = $idToCopy->id;
        
        return $id;
    }
    
    /**
     * Creates a new identity from a value.
     * 
     * @param mixed $value The desired value for the identity, must be convertible to string.
     * 
     * @return static The new identity.
     */
    public static function from($value)
    {
        self::assertIntegerOrString($value);
        
        $id = new static();
        
        $id->id = $value;
        
        return $id;
    }
    
    /**
     * Clones an identity
     */
    public function __clone()
    {
        $this->initialize();
    }
    
    /**
     * {@inheritdoc}
     */
    public function equals($value): bool
    {
        if (!($value instanceof static)) {
            return false;
        }

        return $this->id() === $value->id();
    }
    
    /**
     * Gets the identity of an entity.
     *
     * @return mixed The entity's identity.
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * The string representation of an entity's identity.
     *
     * @return string The string representation of the identity.
     */
    public function __toString(): string
    {
        return (string) $this->id();
    }
    
    /**
     * Asserts if a value is an integer or a string.
     * 
     * @param mixed $value The value to assert against.
     * 
     * @return void
     * 
     * @throws \InvalidArgumentException If the value is neither an integer or a string.
     */
    protected static function assertIntegerOrString($value)
    {
        try {
            \Assert\Assert::lazy()->tryAll()
                ->that($value, 'value id')->integer()
                ->that($value, 'value id')->string()
                ->verifyNow();
        } catch(LazyAssertionException $exception) {
            if (2 === count($exception->getErrorExceptions())) {
                throw new \InvalidArgumentException('The value of an identity must be either an integer or a string.');
            }
        }
        
        return;
    }

    /**
     * Constructs an identity.
     */
    protected function __construct()
    {
        $this->initialize();
    }
    
    /**
     * Initializes an identity.
     */
    protected function initialize()
    {
        $this->id = null;
    }

}

