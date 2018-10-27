<?php

namespace ddd\Model\Identity\Exception;

class IdentityValueException extends \DomainException
{
    public static function becauseAnIndentityCantBeEmpty(): self
    {
        return new self('The value of an identity must not be empty.');
    }

    public static function becauseAnIdentityMustBeConvertibleIntoAString(): self
    {
        return new self('The value of an identity must be convertible into a string.');
    }
}
