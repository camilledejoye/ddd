<?php

namespace ddd\Event;

use SplDoublyLinkedList;
use SplFixedArray;
use ddd\Event\Exception\AggregateHistoryException;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;
use ddd\Identity\IdentifiesAnAggregate;

/**
 * An event stream, which is a queue used to store events.
 *
 * @final
 * @see \Iterator
 * @see \Countable
 */
class AggregateHistory implements ImmutableEventStream, AggregateEventStream
{
    use BasicAggregateEventStream;

    /**
     * @var SplFixedArray
     */
    private $queue;

    /**
     * Creates a new event stream from an array.
     *
     * @param IdentifiesAnAggregate $aggregateId
     * @param DomainEvents $array
     *
     * @return static
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     */
    public static function fromArray(IdentifiesAnAggregate $aggregateId, array $events)
    {
        return new static($aggregateId, $events);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->queue->current();
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        return $this->queue->next();
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->queue->key();
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->queue->valid();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        return $this->queue->rewind();
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return $this->queue->count();
    }

    /**
     * Initializes the event stream.
     *
     * @param IdentifiesAnAggregate $aggregateId
     * @param DomainEvents $events
     *
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     */
    protected function __construct(IdentifiesAnAggregate $aggregateId, array $events)
    {
        $this->setAggregateId($aggregateId);

        foreach ($events as $event) {
            $this->assertThatAnEventIsValid($event);
        }

        $this->queue = SplFixedArray::fromArray($events, false);
    }
}
