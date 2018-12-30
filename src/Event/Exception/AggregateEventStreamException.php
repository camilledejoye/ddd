<?php

declare(strict_types=1);

namespace ddd\Event\Exception;

abstract class AggregateEventStreamException
{
    public static function becauseADomainEventDoesntReferToTheAggregate(): CorruptedAggregateEventStreamException
    {
        return new CorruptedAggregateEventStreamException();
    }
}
