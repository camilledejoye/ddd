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
     * @param DomainEvent[] $array
     *
     * @return static
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     */
    public static function fromIterable(IdentifiesAnAggregate $aggregateId, iterable $events)
    {
        return new static(
            $aggregateId,
            is_array($events) ? $events : \iterator_to_array($events, false)
        );
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
     * @param DomainEvent[] $events
     *
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     */
    protected function __construct(IdentifiesAnAggregate $aggregateId, array $events)
    {
        $this->setAggregateId($aggregateId);

        \array_walk($events, [$this, 'assertThatAnEventIsValid']);

        $this->queue = SplFixedArray::fromArray($events, false);
    }
}
