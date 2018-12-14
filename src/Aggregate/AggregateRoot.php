<?php

namespace ddd\Aggregate;

use ddd\Common\RefersToAnAggregate;

interface AggregateRoot extends IsEventSourced, RefersToAnAggregate
{
}
