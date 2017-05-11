<?php

namespace ddd\Model\Identity;

use Assert\Assert;
use Assert\Assertion;
use Assert\LazyAssertionException;

use ddd\Model\Identity\Identity;

/**
 * Represents an identity.
 * 
 * @author ely
 */
class BasicIdentity implements Identity
{
    
    /**
     * @var mixed The identity of the entity.
     */
    protected $id;
    
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
        Assertion::isInstanceOf($idToCopy, static::class);
        
        $id = new static();
        
        $id->id = $idToCopy->value();
        
        return $id;
    }
    
    /**
     * {@inheritdoc}
     * 
     * @throws \InvalidArgumentException If the value is neither an integer a string or null.
     */
    public static function from($value)
    {
        self::assertIntegerOrString($value);
        Assertion::nullOrNotEmpty($value);
        
        $id = new static();
        
        $id->id = $value;
        
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
    public function equals($value): bool
    {
        if (!($value instanceof static)) {
            return false;
        }

        return $this->value() === $value->value();
    }
    
    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }
    
    /**
     * Asserts if a value is an integer or a string.
     * 
     * @param mixed $value The value to assert against.
     * 
     * @return void
     * 
     * @throws \InvalidArgumentException If the value is neither an integer a string or null.
     */
    protected static function assertIntegerOrString($value)
    {
        try {
            Assert::lazy()->tryAll()
                ->that($value, 'value id')->nullOr()->integer()
                ->that($value, 'value id')->nullOr()->string()
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
