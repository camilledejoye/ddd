<?php

namespace ddd\Event;

use ddd\Event\Exception\AggregateEventStreamException;
use ddd\Event\Exception\CorruptedAggregateEventStreamException;
use ddd\Event\Exception\EventStreamException;
use ddd\Identity\IdentifiesAnAggregate;

trait BasicAggregateEventStream
{
    use BasicEventStream;

    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    /**
     * {@inheritdoc}
     *
     * @return IdentifiesAnAggregate
     */
    public function aggregateId(): IdentifiesAnAggregate
    {
        return $this->aggregateId;
    }

    /**
     * {@inheritdoc}
     */
    protected static function acceptableEventType(): string
    {
        return DomainEvent::class;
    }

    /**
     * Asserts that an event is of an acceptable type for an event stream.
     *
     * @param mixed $event
     *
     * @return void
     *
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     * @see BasicAggregateEventStream::acceptableEventType()
     */
    protected function assertThatAnEventIsValid($event)
    {
        $expectedType = static::acceptableEventType();

        if (!($event instanceof $expectedType)) {
            throw EventStreamException::becauseAWrongEventTypeWasProvided($expectedType, $event);
        }

        if (!$event->aggregateId()->equals($this->aggregateId())) {
            throw AggregateEventStreamException::becauseADomainEventDoesntReferToTheAggregate();
        }
    }

    /**
     * Sets the aggregate identity.
     *
     * @param IdentifiesAnAggregate $aggregateId
     */
    protected function setAggregateId(IdentifiesAnAggregate $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }
}
