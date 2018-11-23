<?php

namespace ddd\Test\Aggregate;

use ddd\Aggregate\AggregateRoot as AggregateRootInterface;
use ddd\Aggregate\BasicAggregateRoot;
use PHPUnit\Framework\TestCase;
use ddd\Event\AggregateHistory;
use ddd\Event\DomainEvent;
use ddd\Identity\IdentifiesAnAggregate;
use ddd\Test\Event\AnotherDomainEvent;
use ddd\Test\Event\ADomainEvent;

class BasicAggregateRootTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReconsituteAnAggregateFromHisHistory()
    {
        $aggregateId = $this->createAnAggregateId();
        $events = $this->createAListOfEvents($aggregateId);
        $aggregateHistory = AggregateHistory::fromArray($aggregateId, $events);

        $sut = AggregateRoot::reconstituteFrom($aggregateHistory);

        $this->assertEquals(3, $sut->onADomainEventCount);
        $this->assertEquals(2, $sut->onAnotherDomainEventCount);
    }

    /**
     * @test
     */
    public function shouldRecordAndApplyAnEvent()
    {
        $sut = AggregateRoot::create($this->createAnAggregateId());
        $sut->recordADomainEvent();
        $sut->pendingEvents()->rewind();

        $this->assertInstanceOf(ADomainEvent::class, $sut->pendingEvents()->current());
        $this->assertEquals(1, $sut->onADomainEventCount);

        return $sut;
    }

    /**
     * @test
     * @depends shouldRecordAndApplyAnEvent
     */
    public function shouldClearTheListOfPendingEvents(AggregateRoot $sut)
    {
        $sut->clearPendingEvents();

        $this->assertCount(0, $sut->pendingEvents());
    }

    /**
     * @test
     */
    public function shouldBeEqualsToItself()
    {
        $aggregateId = $this->createAnAggregateId();
        $sut = AggregateRoot::create($aggregateId);
        $otherSut = AggregateRoot::create($aggregateId);

        $this->assertTrue($sut->equals($otherSut));
    }

    /**
     * @test
     * @dataProvider provideDifferentsAggregatesRoot
     */
    public function shouldNotBeEqualsToSomeOthersAggregatesRoot($other)
    {
        $sut = AggregateRoot::create($this->createAnAggregateId());

        $this->assertFalse($sut->equals($other));
    }

    public function provideDifferentsAggregatesRoot()
    {
        return [
            'a non object value' => [true],
            'a totally different kind of object' => [new \StdClass()],
            'another king of aggregate' => [$this->createMock(AggregateRootInterface::class)],
            'the same kind of aggregate with a different identity' => [
                AggregateRoot::create($this->createAnAggregateId())
            ],
        ];
    }

    /**
     * @return IdentifiesAnAggregate
     */
    private function createAnAggregateId()
    {
        $aggregateId = $this->createMock(IdentifiesAnAggregate::class);
        $aggregateId
            ->method('equals')
            ->willReturnCallback(function ($other) use ($aggregateId) {
                return $other === $aggregateId;
            });

        return $aggregateId;
    }

    /**
     * @return ADomainEvent
     */
    private function createAADomainEvent(IdentifiesAnAggregate $aggregateId)
    {
        return new ADomainEvent($aggregateId);
    }

    /**
     * @return AnotherDomainEvent
     */
    private function createAnAnotherDomainEvent(IdentifiesAnAggregate $aggregateId)
    {
        return new AnotherDomainEvent($aggregateId);
    }

    /**
     * @return DomainEvent[]
     */
    private function createAListOfEvents(IdentifiesAnAggregate $aggregateId)
    {
        return [
            $this->createAnAnotherDomainEvent($aggregateId),
            $this->createAADomainEvent($aggregateId),
            $this->createAADomainEvent($aggregateId),
            $this->createAnAnotherDomainEvent($aggregateId),
            $this->createAADomainEvent($aggregateId),
        ];
    }
}
