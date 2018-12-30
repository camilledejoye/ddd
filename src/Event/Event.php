<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Interface for all events.
 */
interface Event
{
    /**
     * Creates a new event from its normalized form.
     *
     * @param NormalizedEvent $normalizedEvent
     *
     * @return Event
     */
    public static function fromNormalizedEvent(NormalizedEvent $normalizedEvent): Event;

    /**
     * Gets the date when the event occured.
     *
     * @return \DateTimeImmutable the date
     */
    public function occuredOn();

    /**
     * Returns an array containing the raw data of an event.
     * The format does not matter, only the event will deal with this array.
     * But you must not tampered it.
     *
     * @return array
     */
    public function payload(): array;
}
