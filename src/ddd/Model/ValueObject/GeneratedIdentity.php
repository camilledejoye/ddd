<?php

namespace ddd\Model\ValueObject;

use Assert\Assertion;

use ddd\Model\ValueObject\Identity;

/**
 * Represents an identity of an entity generate with a Generator.
 *
 * @see ddd\Utility\Generator
 * 
 * @author ely
 */
class GeneratedIdentity extends Identity
{

    /**
     * @var callable A generator for the identity.
     */
    private $generator;
    
    /**
     * Generates a new identity with a generator.
     *
     * @param callable $generator The generator.
     * 
     * @return static The generated identity.
     */
    public static function generateWith(callable $generator)
    {
//        Je rajoute une méthode, classe enfant c'est logique
//        Mais UuidIdentity ne dois pas être appelée avec generateWith
//        Ou est-ce acceptable ???
        
        $id = new static();
        $id->setGenerator($generator);
        
        $id->id = $id->invokeGenerator();
        
        return $id;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function copy($idToCopy)
    {
        Assertion::isInstanceOf($idToCopy, static::class);
        
        $id = new static();
        $id->setGenerator($idToCopy->generator);
        
        $id->id = $idToCopy->id;
        
        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->id = $this->invokeGenerator();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function __construct()
    {
        parent::__construct();
        
        $this->generator = null;
    }
    
    /**
     * Sets a generator for an identity.
     * 
     * @param callable $generator The generator.
     */
    protected function setGenerator(callable $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generates an identity.
     * 
     * @return mixed The generated identity value.
     */
    protected function invokeGenerator()
    {
        return null === $this->generator
            ? null
            : call_user_func($this->generator);
    }

}
