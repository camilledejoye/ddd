<?php

declare(strict_types=1);

namespace ddd\Test\Aggregate;

use ddd\Aggregate\AggregateRoot as Base;
use ddd\Aggregate\BasicAggregateRoot;
use ddd\Event\AggregateChanges;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Test\Event\AnotherDomainEvent;
use ddd\Test\Event\ADomainEvent;

class AggregateRoot implements Base
{
    use BasicAggregateRoot;

    public $onADomainEventCount;
    public $onAnotherDomainEventCount;

    /**
     * @return self
     */
    public static function create(IdentifiesAnAggregate $aggregateId)
    {
        return new self($aggregateId);
    }

    protected function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->setId($aggregateId);
        $this->pendingEvents = AggregateChanges::createFor($aggregateId);
        $this->onADomainEventCount = 0;
        $this->onAnotherDomainEventCount = 0;
    }

    public function recordADomainEvent()
    {
        $this->recordThat(new ADomainEvent($this->id()));
    }

    public function recordAnotherDomainEvent()
    {
        $this->recordThat(new AnotherDomainEvent($this->id()));
    }

    protected function onADomainEvent(ADomainEvent $event)
    {
        ++$this->onADomainEventCount;

        return null;
    }

    protected function onAnotherDomainEvent(AnotherDomainEvent $event)
    {
        ++$this->onAnotherDomainEventCount;

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function aggregateId(): IdentifiesAnAggregate
    {
        return null;
    }
}
