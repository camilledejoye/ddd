<?php

namespace ddd\Event;

use SplDoublyLinkedList;
use SplQueue;
use ddd\Event\Exception\EventStreamException;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;
use ddd\Identity\IdentifiesAnAggregate;

/**
 * An event stream, which is a queue used to store events.
 *
 * @final
 * @see \Iterator
 * @see \Countable
 */
class AggregateChanges implements GrowingEventStream, AggregateEventStream
{
    use BasicAggregateEventStream;

    /**
     * @var SplQueue
     */
    private $queue;

    /**
     * Creates a new event stream from an array.
     *
     * @param IdentifiesAnAggregate $aggregateId
     * @param DomainEvent[] $events
     *
     * @return static
     * @throws WrongEventTypeWasProvidedException
     * @throws CorruptedAggregateEventStreamException
     */
    public static function fromArray(IdentifiesAnAggregate $aggregateId, array $events)
    {
        $eventStream = new static($aggregateId);

        array_walk($events, [$eventStream, 'push']);
        $eventStream->rewind();

        return $eventStream;
    }

    /**
     * Creates an empty event stream for an aggregate root.
     *
     * @param IdentifiesAnAggregate $aggregateId
     *
     * @return static
     */
    public static function createFor(IdentifiesAnAggregate $aggregateId)
    {
        return new static($aggregateId);
    }

    /**
     * {@inheritdoc}
     *
     * @return DomainEvent
     */
    public function push(Event $event)
    {
        static::assertThatAnEventIsValid($event);

        $this->queue->enqueue($event);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return DomainEvent
     */
    public function pop()
    {
        return $this->queue->dequeue();
    }

    /**
     * {@inheritdoc}
     *
     * @return DomainEvent[] The domain events previously stored by the stream.
     */
    public function clear()
    {
        $events = [];

        $this->queue->setIteratorMode(SplDoublyLinkedList::IT_MODE_DELETE);
        foreach ($this->queue as $event) {
            $events[] = $event;
        }
        $this->queue->setIteratorMode(SplDoublyLinkedList::IT_MODE_KEEP);

        return $events;
    }

    /**
     * {@inheritDoc}
     *
     * @return Event
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
     */
    protected function __construct(IdentifiesAnAggregate $aggregateId)
    {
        $this->setAggregateId($aggregateId);
        $this->queue = new SplQueue();
    }
}
