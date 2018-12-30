<?php

declare(strict_types=1);

namespace ddd\Test\Event;

use ddd\Event\BasicDomainEvent;
use ddd\Event\DomainEvent;
use ddd\Event\NormalizedDomainEvent;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Identity\Uuid;

class ADomainEvent implements DomainEvent
{
    use BasicDomainEvent;

    protected static function doFromNormalizedEvent(NormalizedDomainEvent $normalizedEvent): DomainEvent
    {
        return new self(
            Uuid::fromString($normalizedEvent->aggregateId())
        );
    }

    public function payload(): array
    {
        return [];
    }

    public function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->initializeTheEvent($aggregateId);
    }
}
