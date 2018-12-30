<?php

declare(strict_types=1);

namespace ddd\Test\Event;

use DateTimeImmutable;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use ddd\Event\NormalizedDomainEvent;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Identity\Uuid;

class BasicDomainEventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateANewEvent()
    {
        $currentDate = $this->createADate('1992-06-18 00:30:15');
        $sut = $this->createPartialMock(ADomainEvent::class, ['now']);
        $sut->expects($this->once())
            ->method('now')
            ->willReturn($currentDate);

        $reflection = new ReflectionClass($sut);
        $constructor = $reflection->getConstructor();
        $aggregateId = $this->createAnAggregateId();
        $constructor->invoke($sut, $aggregateId);

        $this->assertSame($aggregateId, $sut->aggregateId());
        $this->assertSame($currentDate, $sut->occuredOn());
    }

    /**
     * @test
     */
    public function shouldRebuildAnEvent()
    {
        $aggregateId = $this->createAnAggregateId();
        $occuredOn = $this->createADate('2016-01-26 13:14:20');
        $payload = [];
        $sut = ADomainEvent::fromNormalizedEvent(new NormalizedDomainEvent(
            ADomainEvent::class,
            (string) $aggregateId,
            $occuredOn,
            $payload
        ));

        $this->assertTrue($sut->aggregateId()->equals($aggregateId));
        $this->assertSame($occuredOn, $sut->occuredOn());
    }

    private function createAnAggregateId(): IdentifiesAnAggregate
    {
        return Uuid::generate();
    }

    private function createADate(string $dateAsString)
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateAsString);
    }
}
