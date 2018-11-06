<?php

namespace ddd\Event;

/**
 * Interface for all events.
 */
interface Event
{
    /**
     * Gets the date when the event occured.
     *
     * @return \DateTimeImmutable The date.
     */
    public function occuredOn();
}
