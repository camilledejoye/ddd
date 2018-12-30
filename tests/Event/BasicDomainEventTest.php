<?php

declare(strict_types=1);

namespace ddd\Test\Event;

use DateTimeImmutable;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use ddd\Identity\IdentifiesAnAggregate;

class BasicDomainEventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldProvideTheDateOfWhenTheEventOccured()
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '1992-06-18 00:30:15');
        $sut = $this->createPartialMock(ADomainEvent::class, ['now']);
        $sut
            ->method('now')
            ->willReturn($date);

        $reflection = new ReflectionClass($sut);
        $constructor = $reflection->getConstructor();
        $constructor->invoke($sut, $this->createAnAggregateId());

        $this->assertSame($date, $sut->occuredOn());
    }

    /**
     * @test
     */
    public function shouldProvideAnAggregateId()
    {
        $aggregateId = $this->createAnAggregateId();
        $sut = new ADomainEvent($aggregateId);

        $this->assertSame($aggregateId, $sut->aggregateId());
    }

    private function createAnAggregateId(): IdentifiesAnAggregate
    {
        return $this->createMock(IdentifiesAnAggregate::class);
    }
}
