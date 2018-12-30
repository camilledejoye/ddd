<?php

declare(strict_types=1);

namespace ddd\Aggregate;

use ddd\Event\AggregateChanges;
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
     */
    public static function reconstituteFrom(AggregateHistory $history);

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
