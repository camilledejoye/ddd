<?php

declare(strict_types=1);

namespace ddd\Aggregate;

use ddd\Common\RefersToAnAggregate;

interface AggregateRoot extends IsEventSourced, RefersToAnAggregate
{
}
