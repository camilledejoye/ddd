<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Interface for all events.
 */
interface Event
{
    /**
     * Gets the date when the event occured.
     *
     * @return \DateTimeImmutable the date
     */
    public function occuredOn();
}
