<?php

declare(strict_types=1);

namespace ddd\Aggregate;

use ddd\Event\AggregateChanges;
use ddd\Event\AggregateEventStream;
use ddd\Event\AggregateHistory;

/**
 * Represents any event sourced object.
 */
interface IsEventSourced
{
    /**
     * Reconstitutes an object from it's history.
     *
     * @param AggregateHistory $history
     *
     * @return IsEventSourced
     */
    public static function reconstituteFrom(AggregateHistory $history);

    /**
     * Replays a list of events onto an aggregate.
     *
     * @param AggregateChanges $events
     *
     * @return static
     */
    public function replay(AggregateEventStream $events);

    /**
     * Gets the pending events.
     *
     * @return AggregateChanges
     */
    public function pendingEvents(): AggregateChanges;

    /**
     * Clears the pending events.
     *
     * @return static
     *
     * @private
     */
    public function clearPendingEvents();
}
