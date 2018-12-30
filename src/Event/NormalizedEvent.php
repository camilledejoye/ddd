<?php

declare(strict_types=1);

namespace ddd\Event;

use DateTimeImmutable;

class NormalizedEvent
{
    /**
     * @var string The type of the original event
     */
    private $type;

    /**
     * @var DateTimeImmutable
     */
    private $occuredOn;

    /**
     * @var array
     */
    private $payload;

    /**
     * Creates a normalized event.
     *
     * @param string            $type
     * @param DateTimeImmutable $occuredOn
     * @param array             $payload
     */
    public function __construct(string $type, DateTimeImmutable $occuredOn, array $payload)
    {
        $this->type = $type;
        $this->occuredOn = $occuredOn;
        $this->payload = $payload;
    }

    /**
     * Gets the type of a normalized event.
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Gets the date of when an event occured.
     *
     * @return DateTimeImmutable
     */
    public function occuredOn(): DateTimeImmutable
    {
        return $this->occuredOn;
    }

    /**
     * Gets the payload of an event.
     *
     * @return array
     */
    public function payload(): array
    {
        return $this->payload;
    }
}
