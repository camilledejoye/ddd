<?php

declare(strict_types=1);

namespace ddd\Event\Exception;

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
