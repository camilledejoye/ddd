<?php

declare(strict_types=1);

namespace ddd\Event;

use ddd\Common\RefersToAnAggregate;

/**
 * An aggregate event stream.

 *
 * @see EventStream
 * @see RefersToAnAggregate
 */
interface AggregateEventStream extends EventStream, RefersToAnAggregate
{
}
