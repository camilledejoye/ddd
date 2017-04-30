<?php

namespace ddd\Model\ValueObject;

/**
 * Used to enforce type hinting.
 * 
 * @author ely
 */
trait GeneratedIdentityTrait
{

    /**
     * Initializes an identity.
     *
     * @param callable $generator The generator.
     * @param self $id (optional) The already existing identity of the entity.
     */
    public function __construct(callable $generator, self $id = null)
    {
        parent::__construct($generator, $id);
    }

}

