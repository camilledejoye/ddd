<?php

declare(strict_types=1);

namespace ddd\Event;

use ddd\Event\Exception\EventStreamException;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;

trait BasicEventStream
{
    /**
     * Gets the accepted type of events for an event stream.
     *
     * @return string
     */
    abstract protected static function acceptableEventType(): string;

    /**
     * Asserts that an event is of an acceptable type for an event stream.
     *
     * @param mixed $event
     *
     * @throws WrongEventTypeWasProvidedException
     *
     * @see BasicEventStream::acceptableEventType()
     */
    protected function assertThatAnEventIsValid($event)
    {
        $expectedType = static::acceptableEventType();

        if (!($event instanceof $expectedType)) {
            throw EventStreamException::becauseAWrongEventTypeWasProvided($expectedType, $event);
        }
    }
}
