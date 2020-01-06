Linio Queue
============
[![Latest Stable Version](https://poser.pugx.org/linio/queue/v/stable.svg)](https://packagist.org/packages/linio/queue) [![License](https://poser.pugx.org/linio/queue/license.svg)](https://packagist.org/packages/linio/queue) [![Build Status](https://secure.travis-ci.org/LinioIT/queue.png)](http://travis-ci.org/LinioIT/queue) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/queue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/queue/?branch=master)

Linio Queue abstracts work queues, used to distribute time-consuming tasks among multiple workers.

Install
-------

The recommended way to install Linio Queue is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "linio/queue": "~3.0"
    }
}
```

Tests
-----

To run the test suite, you need install the dependencies via composer, then
run PHPUnit.

    $ composer install
    $ phpunit

Usage
-----

The library is very easy to use: first, you have to register the service. For
Silex, a service provider is included. Just register it:

```php
<?php

use Linio\Component\Queue\QueueService;
use Linio\Component\Queue\Adapter;

$queue = new QueueService();
$queue->setAdapter(new Adapter\RabbitAdapter([
    'host' => 'localhost',
    'port' => 5672,
    'username' => 'guest',
    'password' => 'guest',
    'vhost' => '/'
]));

```

In order to create a work queue, you must extend the abstract class `Job`:

```php
<?php

use Linio\Component\Queue\Job;

class HelloWorldJob extends Job
{
    public function perform()
    {
        echo sprintf("Hello %s!\n", $this->payload);
        $this->finish();
    }
}

```

Note that you must always `finish()` a job to remove it from the queue. You
can also `fail()` jobs. Now, in order to publish messages to a work queue:

```php
<?php

use Linio\Component\Queue\QueueService;

$queue = new QueueService();
$queue->add(new HelloWorldJob('John')); // "John" is the payload

```

And to consume messages from the work queue:

```php
<?php

use Linio\Component\Queue\QueueService;

$queue = new QueueService();
$queue->perform(new HelloWorldJob());

```
