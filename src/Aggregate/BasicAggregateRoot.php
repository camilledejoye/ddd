<?php

namespace ddd\Aggregate;

use ddd\Event\AggregateChanges;
use ddd\Event\AggregateHistory;
use ddd\Event\DomainEvent;
use ddd\Identity\IdentifiesAnAggregate;

trait BasicAggregateRoot
{
    /**
     * @var IdentifiesAnAggregate
     */
    private $id;

    /**
     * @var AggregateChanges
     */

    private $pendingEvents;

    /**
     * {@inheritdoc}
     */
    public static function reconstituteFrom(AggregateHistory $history)
    {
        $aggregate = new static($history->aggregateId());

        foreach ($history as $event) {
            $aggregate->apply($event);
        }

        return $aggregate;
    }

    /**
     * {@inheritdoc}
     */
    public function pendingEvents(): AggregateChanges
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
    public function equals($other): bool
    {
        if (!\is_object($other)) {
            return false;
        }

        if (\get_class($other) !== \get_class()) {
            return false;
        }

        return $other->id()->equals($this->id());
    }

    /**
     * Gets the identity of an aggregate root.
     *
     * @return IdentifiesAnAggregate
     */
    public function id(): IdentifiesAnAggregate
    {
        return $this->id;
    }

    /**
     * Sets the identity of the aggregate root.
     *
     * @param IdentifiesAnAggregate $id
     *
     * @return static
     */
    protected function setId(IdentifiesAnAggregate $id)
    {
        $this->id = $id;

        return $this;
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
