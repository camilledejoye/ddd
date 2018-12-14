<?php

namespace ddd\Event;

use DateTimeImmutable;
use ddd\Identity\IdentifiesAnAggregate;

/**
 * Basic implementation for a domain event.
 */
trait BasicDomainEvent
{
    /**
     * @var DateTimeImmutable
     */
    private $occuredOn;

    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    /**
     * {@inheritdoc}
     */
    public function occuredOn()
    {
        return $this->occuredOn;
    }

    /**
     * {@inheritdoc}
     */
    public function aggregateId()
    {
        return $this->aggregateId;
    }

    /**
     * Initialize a domain event.
     * If $occuredOn is not provided, initialize the event with the current date time.
     *
     * @param IdentifiesAnAggregate $aggregateId
     * @param DateTimeImmutable|null $occuredOn
     *
     * @return void
     *
     * @see self::now()
     */
    protected function initializeTheEvent(
        IdentifiesAnAggregate $aggregateId,
        DateTimeImmutable $occuredon = null
    ): void {
        $this->occuredOn   = $occuredon ?? $this->now();
        $this->aggregateId = $aggregateId;
    }

    /**
     * Gets the current date time.
     * Used to be make the trait testable.
     *
     * @return DateTimeImmutable
     */
    protected function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
