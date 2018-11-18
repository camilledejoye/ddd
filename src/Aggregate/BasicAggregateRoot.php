<?php

namespace ddd\Aggregate;

use ddd\Event\AggregateChanges;
use ddd\Event\AggregateHistory;
use ddd\Event\DomainEvent;

trait BasicAggregateRoot
{
    /**
     * @var AggregateChanges
     */
    private $pendingEvents;

    /**
     * {@inheritdoc}
     */
    public function getPendingEvents(): AggregateChanges
    {
        return $this->pendingEvents;
    }

    /**
     * {@inheritdoc}
     */
    public function clearPendingEvents()
    {
        $this->pendingEvents->clear();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected static function doReconstituteFrom(AggregateHistory $history)
    {
        $aggregate = new static($history->aggregateId());

        foreach ($history as $event) {
            $aggregate->apply($event);
        }

        return $aggregate;
    }

    /**
     * Records an event.
     *
     * @param DomainEvent $event
     *
     * @return void
     */
    protected function recordThat(DomainEvent $event): void
    {
        $this->pendingEvents->push($event);
        $this->apply($event);
    }

    /**
     * Apply an event onto the aggregate.
     *
     * @param DomainEvent $event
     *
     * @return void
     */
    protected function apply(DomainEvent $event): void
    {
        $applyMethod = $this->applyMethodName($event);

        \call_user_func([$this, $applyMethod], $event);
    }

    /**
     * Gets the name of the method to call to apply an event.
     *
     * @param DomainEvent $event
     *
     * @return string
     */
    private function applyMethodName(DomainEvent $event): string
    {
        $eventFqn = \get_class($event);
        $eventTypeParts = \explode('\\', $eventFqn);
        $eventName = \end($eventTypeParts);
        $applyMethod = 'on' . $eventName;

        return $applyMethod;
    }
}
