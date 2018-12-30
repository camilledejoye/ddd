<?php

declare(strict_types=1);

namespace ddd\Event;

use ddd\Common\RefersToAnAggregate;

/**
 * Interface for domain events.
 *
 * @author cdejoye
 */
interface DomainEvent extends Event, RefersToAnAggregate
{
}
