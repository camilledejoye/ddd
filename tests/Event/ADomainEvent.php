<?php

declare(strict_types=1);

namespace ddd\Test\Event;

use ddd\Event\BasicDomainEvent;
use ddd\Event\DomainEvent;
use ddd\Identity\IdentifiesAnAggregate;

class ADomainEvent implements DomainEvent
{
    use BasicDomainEvent;

    public function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->initializeTheEvent($aggregateId);
    }
}
