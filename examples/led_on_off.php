<?php

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;

require __DIR__ . '/vendor/autoload.php';


if (!class_exists('\Spi')) {
    die ("Spi extension must be installed (https://github.com/frak/php_spi)");
}

$dev = PiFaceDigital::create();
$dev->init();

// Turn on the first led
$dev->getLeds()[0]->turnOn();

sleep(2);

// Turn off the first led
$dev->getLeds()[0]->turnOff();
