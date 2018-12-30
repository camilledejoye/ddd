<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Interface for all mutable event stream implementations.
 *
 * @see EventStream
 */
interface GrowingEventStream extends EventStream
{
    /**
     * Pushes an event to the top of the stream.
     *
     * @param Event $event
     *
     * @return static
     */
    public function push(Event $event);

    /**
     * Pops the first event of the stream.
     *
     * @return Event
     */
    public function pop();

    /**
     * Clears the event stream.
     *
     * @return Event[] the events previously stored by the stream
     */
    public function clear();
}
