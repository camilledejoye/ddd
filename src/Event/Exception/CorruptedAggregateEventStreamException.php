<?php

namespace ddd\Event\Exception;

/**
 * Exception thrown when trying to add a domain event, of another aggregate,
 * to an aggregate event stream.
 *
 * @see \InvalidArgumentException
 */
class CorruptedAggregateEventStreamException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct(
            'Tried to add a domain event from another aggregate to an AggregateEventStream'
        );
    }
}
