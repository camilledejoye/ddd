<?php

declare(strict_types=1);

namespace ddd\Event;

use DateTimeImmutable;
use ddd\Identity\IdentifiesAnAggregate;

class NormalizedDomainEvent extends NormalizedEvent
{
    /**
     * @var string
     */
    private $aggregateId;

    /**
     * Creates a normalized domain event.
     *
     * @param string                $type
     * @param IdentifiesAnAggregate $aggregateId
     * @param DateTimeImmutable     $occuredOn
     * @param array                 $payload
     */
    public function __construct(
        string $type,
        string $aggregateId,
        DateTimeImmutable $occuredOn,
        array $payload
    ) {
        parent::__construct($type, $occuredOn, $payload);

        $this->aggregateId = $aggregateId;
    }

    /**
     * Gets the identity of the aggregate a domain event refers to.
     *
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->aggregateId;
    }
}
