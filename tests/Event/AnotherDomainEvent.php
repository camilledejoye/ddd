<?php

namespace ddd\Test\Event;

use ddd\Event\DomainEvent;
use ddd\Identity\IdentifiesAnAggregate;

class AnotherDomainEvent implements DomainEvent
{
    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    public function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    /**
     * {@inheritDoc}
     */
    public function occuredOn()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function aggregateId()
    {
        return $this->aggregateId;
    }
}
