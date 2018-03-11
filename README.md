# seatsio-php, the official Seats.io PHP client library

[![Build Status](https://travis-ci.org/seatsio/seatsio-php.svg?branch=master)](https://travis-ci.org/seatsio/seatsio-php)
[![Latest Stable Version](https://poser.pugx.org/seatsio/seatsio-php/v/stable)](https://packagist.org/packages/seatsio/seatsio-php)

This is the official PHP client library for the [Seats.io V2 REST API](https://www.seats.io/docs/api-v2).

## Installing seatsio-php

The recommended way to install seatsio-php is through [Composer](http://getcomposer.org).

```bash
composer require seatsio/seatsio-php
```

The minimum required PHP version is 5.5.

## Versioning

seatsio-php only uses major version numbers: v5, v6, v7 etc. Each release - backwards compatible or not - receives a new major version number.

The reason: we want to play safe and assume that each release _might_ break backwards compatibility.

## Examples

### Creating a chart and an event

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>); // can be found on https://app.seats.io/settings
$chart = $seatsio->charts()->create();
$event = $seatsio->events()->create($chart->key);
echo 'Created event with key ' . $event->key;
```

### Booking objects

Changes the object status to ‘booked’. Booked seats are not selectable on a rendered chart.

[https://www.seats.io/docs/api-v2#core-resources-objects-book-objects](https://www.seats.io/docs/api-v2#core-resources-objects-book-objects)

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);
$seatsio->events()->book(<AN EVENT KEY>, ["A-1", "A-2"]);
```

### Booking objects that have been held

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);
$seatsio->events()->book(<AN EVENT KEY>, ["A-1", "A-2"], <A HOLD TOKEN>);
```

### Releasing objects

Changes the object status to ‘free’. Free seats are selectable on a rendered chart.

[https://www.seats.io/docs/api-v2#core-resources-objects-release-objects](https://www.seats.io/docs/api-v2#core-resources-objects-release-objects)

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);
$seatsio->events()->release(<AN EVENT KEY>, ["A-1", "A-2"]);
```

### Changing object status

Changes the object status to a custom status of your choice. If you need more statuses than just booked and free, you can use this to change the status of a seat, table or booth to your own custom status.

[https://www.seats.io/docs/api-v2#core-resources-objects-change-object-status](https://www.seats.io/docs/api-v2#core-resources-objects-change-object-status)

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);
$seatsio->events()->changeObjectStatus(<AN EVENT KEY>, ["A-1", "A-2"], "unavailable");
```

### Event reports

Want to know which seats of an event are booked, and which ones are free? That’s where reporting comes in handy.

The report types you can choose from are:
- byStatus
- byCategoryLabel
- byCategoryKey
- byLabel
- byOrderId

[https://www.seats.io/docs/api-v2#core-resources-event-reports](https://www.seats.io/docs/api-v2#core-resources-event-reports)

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);
$seatsio->events()->reports()->byStatus(<AN EVENT KEY>, <OPTIONAL FILTER>);
```

### Listing charts

```php
$seatsio = new \Seatsio\SeatsioClient(<SECRET KEY>);

$chart1 = $seatsio->charts()->create();
$chart2 = $seatsio->charts()->create();
$chart3 = $seatsio->charts()->create();

$charts = $seatsio->charts()->iterator()->all();
foreach($charts as $chart) {
    echo 'Chart ' . $chart->key;
}
```

## Error handling

When an API call results in a 4xx or 5xx error (e.g. when a chart could not be found), a SeatsioException is thrown.

This exception contains a message string describing what went wrong, and also two other properties:

- `messages`: an array of error messages that the server returned. In most cases, this array will contain only one element.
- `requestId`: the identifier of the request you made. Please mention this to us when you have questions, as it will make debugging easier.
