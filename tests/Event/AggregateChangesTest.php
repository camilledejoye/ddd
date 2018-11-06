<?php

namespace ddd\Test\Event;

use ddd\Event\DomainEvent;
use ddd\Event\AggregateChanges;
use PHPUnit\Framework\TestCase;
use ddd\Event\Event;
use ddd\Event\Exception\CorruptedAggregateEventStreamException;
use ddd\Event\Exception\WrongEventTypeWasProvidedException;
use ddd\Identity\IdentifiesAnAggregate;

class AggregateChangesTest extends TestCase
{
    /**
     * @var AggregateChanges
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
        $this->sut           = AggregateChanges::fromArray(
            $this->aggregateId,
            $this->initialEvents
        );
    }

    /**
     * @test
     */
    public function shouldCreateAnEmptyStream()
    {
        $aggregateId = $this->createAnAggregateId();
        $sut = AggregateChanges::createFor($aggregateId);

        $this->assertCount(0, $sut);
    }

    /**
     * @test
     */
    public function shouldRejectACorruptedEventStream()
    {
        $events = $this->initialEvents;
        $corruptedDomainEvent = $this->createADomainEvent($this->createAnAggregateId());
        $events[(int)(\count($this->initialEvents)/2)] = $corruptedDomainEvent;

        $this->expectException(CorruptedAggregateEventStreamException::class);

        AggregateChanges::fromArray($this->aggregateId, $events);
    }

    /**
     * @test
     */
    public function shouldRejectArrayWithSomethingElseThanADomainEvent()
    {
        $events = $this->initialEvents;
        $events[(int)(\count($this->initialEvents)/2)] = $this->createAnEvent();

        $this->expectException(WrongEventTypeWasProvidedException::class);

        AggregateChanges::fromArray($this->aggregateId, $events);
    }

    /**
     * @test
     */
    public function shouldCreateAStreamFromAnArray()
    {
        $elements = [];
        foreach ($this->sut as $event) {
            $elements[] = $event;
        }

        $this->assertSame($this->initialEvents, $elements);
    }

    /**
     * @test
     */
    public function shouldNotPushSomethingElseThanADomainEvent()
    {
        $this->expectException(WrongEventTypeWasProvidedException::class);

        $this->sut->push($this->createAnEvent());
    }

    /**
     * @test
     */
    public function shouldNotPushAnEventOfAnotherAggregate()
    {
        $this->expectException(CorruptedAggregateEventStreamException::class);

        $domainEventOfAnotherAggregate = $this->createADomainEvent($this->createAnAggregateId());
        $this->sut->push($domainEventOfAnotherAggregate);
    }

    /**
     * @test
     */
    public function shouldPushElementsAtTheEndOfTheStream()
    {
        $event = $this->createADomainEvent();
        $this->sut->push($event);

        $lastEvent = null;
        foreach ($this->sut as $event) {
            $lastEvent = $event;
        }

        $this->assertSame($event, $lastEvent);
    }

    /**
     * @test
     */
    public function shouldPopElementFromTheBeginingOfTheStream()
    {
        $this->assertSame(reset($this->initialEvents), $this->sut->pop());
    }

    /**
     * @test
     */
    public function shouldKeepItsEventsWhenTraversed()
    {
        $initialCount = $this->sut->count();

        foreach ($this->sut as $event) {
        }

        $this->assertCount($initialCount, $this->sut);
    }

    /**
     * @test
     */
    public function shouldBeClearable()
    {
        $this->sut->clear();
        $this->assertCount(0, $this->sut);
    }

    /**
     * @test
     */
    public function shouldReturnItsEventsWhenCleared()
    {
        $events = $this->sut->clear();

        $this->assertEquals($this->initialEvents, $events);
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
    private function createAListOfDomainEvents(IdentifiesAnAggregate $aggregateId = null)
    {
        $events = [];

        for ($i = 0; $i < 9; ++$i) {
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
