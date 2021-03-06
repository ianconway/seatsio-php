<?php

namespace Seatsio\Events;

use DateTime;
use Seatsio\SeatsioClientTest;

class CreateEventTest extends SeatsioClientTest
{

    public function testOnlyChartKeyIsRequired()
    {
        $chart = $this->seatsioClient->charts()->create();

        $event = $this->seatsioClient->events()->create($chart->key);

        self::assertNotNull($event->key);
        self::assertNotNull($event->id);
        self::assertEquals($chart->key, $event->chartKey);
        self::assertFalse($event->bookWholeTables);
        self::assertNotNull($event->createdOn);
        self::assertNull($event->forSaleConfig);
        self::assertNull($event->updatedOn);
    }

    public function testEventKeyCanBePassedIn()
    {
        $chart = $this->seatsioClient->charts()->create();

        $event = $this->seatsioClient->events()->create($chart->key, 'eventje');

        self::assertEquals('eventje', $event->key);
    }

    public function testBookWholeTablesCanBePassedIn()
    {
        $chart = $this->seatsioClient->charts()->create();

        $event = $this->seatsioClient->events()->create($chart->key, null, false);

        self::assertNotNull($event->key);
        self::assertFalse($event->bookWholeTables);
    }

}