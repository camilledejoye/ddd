<?php

namespace ddd\Model\Identity\Exception;

class InvalidUuidException extends IdentityValueException
{
    public static function becauseItsNotAValidUuid(): void
    {
        throw new self('The value is not a valid UUID.');
    }
}
