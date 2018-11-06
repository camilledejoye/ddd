<?php

namespace ddd\Test\Event;

use ddd\Event\AggregateHistory;
use PHPUnit\Framework\TestCase;
use ddd\Event\DomainEvent;
use ddd\Event\Event;
use ddd\Event\Exception\CorruptedAggregateEventStreamException;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;
use ddd\Identity\IdentifiesAnAggregate;

class AggregateHistoryTest extends TestCase
{
    /**
     * @var AggregateHistory
     */
    private $sut;

    /**
     * @var DomainEvent[]
     */
    private $initialEvents;

    /**
     * @var IdentifiesAnAggregate
     */
    private $aggregateId;

    protected function setUp()
    {
        $this->aggregateId   = $this->createAnAggregateId();
        $this->initialEvents = $this->createAListOfDomainEvents();
        $this->sut           = AggregateHistory::fromArray(
            $this->aggregateId,
            $this->initialEvents
        );
    }

    /**
     * @test
     */
    public function shouldRejectArrayWithSomethingElseThanADomainEvent()
    {
        $aggregateId = $this->createAnAggregateId();
        $events = $this->createAListOfDomainEvents($aggregateId);

        $events[(int)(\count($events)/2)] = $this->createAnEvent();

        $this->expectException(WrongEventTypeWasProvidedException::class);
        AggregateHistory::fromArray($aggregateId, $events);
    }

    /**
     * @test
     */
    public function shouldRejectACorruptedEventStream()
    {
        $aggregateId = $this->createAnAggregateId();
        $events = $this->createAListOfDomainEvents($aggregateId);
        $corruptedDomainEvent = $this->createADomainEvent($this->createAnAggregateId());
        $events[(int)(\count($events)/2)] = $corruptedDomainEvent;

        $this->expectException(CorruptedAggregateEventStreamException::class);

        AggregateHistory::fromArray($aggregateId, $events);
    }

    /**
     * @test
     * @dataProvider provideArrayToConstructAggregateHistoryFrom
     */
    public function shouldKeepTheOrderOfTheProvidedArray(IdentifiesAnAggregate $aggregateId, array $events)
    {
        $sutEvents = [];
        foreach (AggregateHistory::fromArray($aggregateId, $events) as $event) {
            $sutEvents[] = $event;
        }

        $this->assertEquals(array_values($events), $sutEvents);
    }

    public function provideArrayToConstructAggregateHistoryFrom()
    {
        $aggregateId = $this->createAnAggregateId();
        $events = $this->createAListOfDomainEvents($aggregateId, 3);
        $shuffleKeys = [19, 5, 100];
        $stringKeys = [ 'first', 'second', 'third'];

        return [
            'consecutive numeric indexes'     => [$aggregateId, $events],
            'non consecutive numeric indexes' => [$aggregateId, \array_combine($shuffleKeys, $events)],
            'string indexes'                  => [$aggregateId, \array_combine($stringKeys, $events)],
        ];
    }

    /**
     * @test
     */
    public function shouldReturnTheCurrentDomainEvent()
    {
        $this->assertSame(current($this->initialEvents), $this->sut->current());

        return [$this->initialEvents, $this->sut];
    }

    /**
     * @test
     * @depends shouldReturnTheCurrentDomainEvent
     */
    public function shouldReturnTheNextDomainEvent($data)
    {
        list($events, $sut) = $data;
        next($events);
        $sut->next();
        $this->assertSame(current($events), $sut->current());

        return [$events, $sut];
    }

    /**
     * @test
     * @depends shouldReturnTheNextDomainEvent
     */
    public function shouldBeInAValidPosition($data)
    {
        list($events, $sut) = $data;
        $this->assertTrue($sut->valid());

        return [$events, $sut];
    }

    /**
     * @test
     * @depends shouldBeInAValidPosition
     */
    public function shouldGetTheKeyOfTheCurrentDomainEvent($data)
    {
        list($events, $sut) = $data;
        $this->assertSame(key($events), $sut->key());

        return [$events, $sut];
    }

    /**
     * @test
     * @depends shouldGetTheKeyOfTheCurrentDomainEvent
     */
    public function shouldBeInAnInvalidPosition($data)
    {
        list($events, $sut) = $data;

        foreach ($sut as $domainEvent) {
        }

        $this->assertFalse($sut->valid());

        return [$events, $sut];
    }

    /**
     * @test
     * @depends shouldBeInAnInvalidPosition
     */
    public function shouldRewindTheHistory($data)
    {
        list($events, $sut) = $data;
        $sut->rewind();
        $this->assertSame(reset($events), $sut->current());

        return [$events, $sut];
    }

    /**
     * @test
     */
    public function shouldCountTheNumberOfDomainEvents()
    {
        $this->assertEquals(count($this->initialEvents), $this->sut->count());
    }

    /**
     * @return DomainEvent[]
     */
    private function createAListOfDomainEvents(
        IdentifiesAnAggregate $aggregateId = null,
        int $numberOfEventsToCreate = 7
    ) {
        $events = [];

        for ($i = 0; $i < $numberOfEventsToCreate; ++$i) {
            $events[] = $this->createADomainEvent($aggregateId);
        }

        return $events;
    }

    /**
     * @return IdentifiesAnAggregate
     */
    private function createAnAggregateId()
    {
        $aggregateId = $this->createMock(IdentifiesAnAggregate::class);
        $aggregateId
            ->method('equals')
            ->willReturnCallback(function ($parameter) use ($aggregateId) {
                return $parameter === $aggregateId;
            });

        return $aggregateId;
    }

    /**
     * @return Event
     */
    private function createAnEvent()
    {
        return $this->createMock(Event::class);
    }

    /**
     * @return DomainEvent
     */
    private function createADomainEvent(IdentifiesAnAggregate $aggregateId = null)
    {
        $domainEvent = $this->createMock(DomainEvent::class);
        $domainEvent = $this->createMock(DomainEvent::class);
        $domainEvent
            ->method('aggregateId')
            ->willReturn($aggregateId ?: $this->aggregateId);

        return $domainEvent;
    }
}
