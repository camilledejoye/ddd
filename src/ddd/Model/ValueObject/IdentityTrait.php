<?php

namespace ddd\Model\ValueObject;

/**
 * Used to enforce type hinting.
 * 
 * @author ely
 */
trait IdentityTrait
{

    /**
     * Initializes an identity.
     *
     * @param self $id (optional) The already existing identity of the entity.
     */
    public function __construct(self $id = null)
    {
        parent::__construct($id);
    }

}

