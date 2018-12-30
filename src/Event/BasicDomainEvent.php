<?php

declare(strict_types=1);

namespace ddd\Event;

use DateTimeImmutable;
use RuntimeException;
use ddd\Identity\IdentifiesAnAggregate;

/**
 * Basic implementation for a domain event.
 */
trait BasicDomainEvent
{
    private static $dateFormat = 'Y-m-d\TH:i:s.uP';

    /**
     * @var DateTimeImmutable
     */
    private $occuredOn;

    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    /**
     * Do the actual creation of the event and set the aggregateId property.
     * The parent::fromNormalizedEvent(NormalizedEvent) will take care of
     * the occuredOn property.
     *
     * @param NormalizedDomainEvent $normalizedEvent
     *
     * @return DomainEvent
     */
    abstract protected function doFromNormalizedEvent(NormalizedDomainEvent $normalizedEvent): DomainEvent;

    /**
     * {@inheritdoc}
     *
     * @return DomainEvent
     *
     * @throws RuntimeException if the normalized event is not an instance of NormalizedDomainEvent
     */
    public static function fromNormalizedEvent(NormalizedEvent $normalizedEvent): Event
    {
        if (!$normalizedEvent instanceof NormalizedDomainEvent) {
            throw new RuntimeException(
                'A domain event can not be created from an "%s" object.',
                NormalizedEvent::class
            );
        }

        $event = static::doFromNormalizedEvent($normalizedEvent);
        $event->occuredOn = $normalizedEvent->occuredOn();

        return $event;
    }

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
    public function aggregateId(): IdentifiesAnAggregate
    {
        return $this->aggregateId;
    }

    /**
     * Initialize a domain event.
     * If $occuredOn is not provided, initialize the event with the current date time.
     *
     * @param IdentifiesAnAggregate  $aggregateId
     * @param DateTimeImmutable|null $occuredOn
     *
     * @see self::now()
     */
    protected function initializeTheEvent(
        IdentifiesAnAggregate $aggregateId,
        DateTimeImmutable $occuredon = null
    ): void {
        $this->occuredOn = $occuredon ?? $this->now();
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

    /**
     * Converts a date into a string.
     * Helper method for when you need to store a date inside the payload.
     *
     * @param DateTimeImmutable $date
     *
     * @return string
     *
     * @see static::$dateFormat
     * @see dateFromString()
     */
    protected static function dateToString(DateTimeImmutable $date): string
    {
        return $date->format(static::$dateFormat);
    }

    /**
     * Converts a string into a date.
     * The date must have been formated using static:$dateFormat.
     *
     * @param string $dateAsString
     *
     * @return DateTimeImmutable
     *
     * @see static::$dateFormat
     * @see dateToString()
     */
    protected static function dateFromString(string $dateAsString): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(static::$dateFormat, $dateAsString);
    }
}
