<?php

namespace ddd\Model\ValueObject;

use ddd\Model\ValueObject\Identity;
use ddd\Utility\Generator;

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
     * @var Generator A generator for the identity.
     */
    private $generator;

    /**
     * Initializes an identity.
     *
     * @param callable $generator The generator.
     * @param self $id (optional) The already existing identity of the entity.
     */
    public function __construct(callable $generator, self $id = null)
    {
        if (!is_callable($generator)) {
            throw new \InvalidArgumentException(sprintf(
                "A generator must be an instance of ddd\Utility\Generator or a valid callable.\nGenerator provided : %s",
                print_r($generator, true)
            ));
        }
        
        $this->generator = $generator;
        
        parent::__construct($id ?? $this->generate());
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->id = $this->generate();
    }
    
    /**
     * Generates an identity.
     * 
     * @return mixed The generated identity.
     */
    private function generate()
    {
        return call_user_func($this->generator);
    }

}
