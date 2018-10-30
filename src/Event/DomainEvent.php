<?php

namespace ddd\Event;

/**
 * Basic implementation for a domain's event.
 *
 * @author cdejoye
 */
class DomainEvent
{
    /**
     * @var \DateTimeImmutable The date when an event occured.
     */
    private $occuredOn;

    /**
     * Gets the date when the event occured.
     *
     * @return \DateTimeImmutable The date.
     */
    public function occuredOn()
    {
        return $this->occuredOn;
    }
}
