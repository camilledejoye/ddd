<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Dummy interface to gave a specific interface to all possible implementations
 * of an immutable event stream.
 *
 * @see EventStream
 */
interface ImmutableEventStream extends EventStream
{
}
