<?php

declare(strict_types=1);

namespace ddd\Event;

/**
 * Its goal is to normalize an event into a generic format.
 * So they can be proccessed by any system.
 */
class EventNormalizer
{
    /**
     * Normalizes an event into a NormalizedEvent or a NormalizedDomainEvent
     * depending on the type of the event.
     *
     * @param Event $event
     *
     * @return NormalizedEvent
     */
    public function normalize(Event $event): NormalizedEvent
    {
        if ($event instanceof DomainEvent) {
            return new NormalizedDomainEvent(
                \get_class($event),
                $event->aggregateId(),
                $event->occuredOn(),
                $event->payload()
            );
        }

        return new NormalizedEvent(
            \get_class($event),
            $event->occuredOn(),
            $event->payload()
        );
    }

    /**
     * Denormalizes an NormalizedEvent into the corresponding Event.
     *
     * @param NormalizedEvent $normalizedEvent
     *
     * @return Event
     */
    public function denormalize(NormalizedEvent $normalizedEvent): Event
    {
        return $normalizedEvent->type()::fromNormalizedEvent($normalizedEvent);
    }
}
