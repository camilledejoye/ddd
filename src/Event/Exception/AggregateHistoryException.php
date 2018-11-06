<?php

namespace ddd\Event\Exception;

use ddd\Event\Exception\WrongEventTypeWasProvidedException;

abstract class AggregateHistoryException
{
    /**
     * @param string $expectedType
     * @param string $invalidValue
     *
     * @return WrongEventTypeWasAdded
     */
    public static function becauseAWrongEventTypeWasProvided(
        string $expectedType,
        $invalidValue
    ): WrongEventTypeWasProvidedException {
        return WrongEventTypeWasProvidedException::fromAnInvalidItem($expectedType, $invalidValue);
    }
}
