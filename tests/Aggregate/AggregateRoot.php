<?php

namespace ddd\Test\Aggregate;

use ddd\Aggregate\AggregateRoot as Base;
use ddd\Aggregate\BasicAggregateRoot;
use ddd\Event\AggregateChanges;
use ddd\Event\AggregateHistory;
use ddd\Event\DomainEvent;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Test\Event\OtherTestEvent;
use ddd\Test\Event\TestEvent;

class AggregateRoot implements Base
{
    use BasicAggregateRoot;

    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    public $onTestEventCount;
    public $onOtherTestEventCount;

    /**
     * @return self
     */
    public static function reconstituteFrom(AggregateHistory $history)
    {
        return self::doReconstituteFrom($history);
    }

    /**
     * @return self
     */
    public static function create(IdentifiesAnAggregate $aggregateId)
    {
        return new self($aggregateId);
    }

    protected function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->aggregateId = $aggregateId;
        $this->pendingEvents = AggregateChanges::createFor($aggregateId);
        $this->onTestEventCount = 0;
        $this->onOtherTestEventCount = 0;
    }

    public function recordTestEvent()
    {
        $this->recordThat(new TestEvent($this->aggregateId));
    }

    public function recordOtherTestEvent()
    {
        $this->recordThat(new OtherTestEvent($this->aggregateId));
    }

    protected function onTestEvent(TestEvent $event)
    {
        ++$this->onTestEventCount;

        return null;
    }

    protected function onOtherTestEvent(OtherTestEvent $event)
    {
        ++$this->onOtherTestEventCount;

        return null;
    }
}
