<?php

namespace ddd\Model\ValueObject;

/**
 * A trait for a standard UUID identity.
 *
 * @author ely
 */
trait UuidEntityIdTrait
{

    public function __construct(self $id = null)
    {
        parent::__construct($id);
    }

}
