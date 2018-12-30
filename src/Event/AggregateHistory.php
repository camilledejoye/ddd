<?php

declare(strict_types=1);

namespace ddd\Event;

use SplFixedArray;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;
use ddd\Identity\IdentifiesAnAggregate;

/**
 * An event stream, which is a queue used to store events.
 *
 * @final
 *
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
     * @param DomainEvent[]         $array
     *
     * @return static
     *
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
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->queue->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return $this->queue->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->queue->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->queue->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        return $this->queue->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->queue->count();
    }

    /**
     * Initializes the event stream.
     *
     * @param IdentifiesAnAggregate $aggregateId
     * @param DomainEvent[]         $events
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
