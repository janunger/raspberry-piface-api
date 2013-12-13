<?php

use Pkj\Raspberry\PiFace\Hardware\Driver;
use Pkj\Raspberry\PiFace\Hardware\PiFace;

require __DIR__ . '/../vendor/autoload.php';


if (!class_exists('\Spi')) {
    die ("Spi extension must be installed (https://github.com/frak/php_spi)");
}

$dev = PiFace::createInstance();
$dev->init();

// Turn on the first led
$dev->getOutputPin(7)->turnOn();

sleep(2);

// Turn off the first led
$dev->getOutputPin(7)->turnOff();
