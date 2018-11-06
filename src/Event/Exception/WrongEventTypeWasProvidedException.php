<?php

namespace ddd\Event\Exception;

class WrongEventTypeWasProvidedException extends \InvalidArgumentException
{
    public static function fromAnInvalidItem(string $expectedType, $invalidValue)
    {
        return new self(sprintf(
            'Expected an array of "%s", got an item of type "%s"',
            $expectedType,
            \is_object($invalidValue) ? \get_class($invalidValue) : \gettype($invalidValue)
        ));
    }
}
