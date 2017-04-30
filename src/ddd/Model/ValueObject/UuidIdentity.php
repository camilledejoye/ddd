<?php

namespace ddd\Model\ValueObject;

use Ramsey\Uuid\Uuid;

use ddd\Model\ValueObject\GeneratedIdentity;

/**
 * Represents an identity as a UUID.
 *
 * @author ely
 */
class UuidIdentity extends GeneratedIdentity
{

    /**
     * Initializes an identity.
     *
     * @param self $id (optional) The already existing identity of the entity.
     */
    public function __construct(self $id = null)
    {
        $generator = function() {
            return Uuid::uuid4()->toString();
        };

        parent::__construct($generator, $id);
    }

}
