<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Top level interface for all event stream.
 *
 * @see \Iterator
 * @see \Countable
 */
interface EventStream extends \Iterator, \Countable
{
}
