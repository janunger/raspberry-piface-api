<?php

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;

require __DIR__ . '/vendor/autoload.php';


if (!class_exists('\Spi')) {
    die ("Spi extension must be installed (https://github.com/frak/php_spi)");
}

$dev = PiFaceDigital::createInstance();
$dev->init();

foreach ($dev->getRelays() as $relay) {
    echo "Turning on relay: $relay\n";
    $relay->turnOn();
    sleep(1);
    echo "Turning off relay: $relay\n";
    $relay->turnOff();
    sleep(1);
}

foreach ($dev->getLeds() as $led) {
    echo "Turning on led: $led\n";
    $led->turnOn();
    sleep(1);
    echo "Turning off led: $led\n";
    $led->turnOff();
    sleep(1);
}

foreach ($dev->getInputPins() as $inputPin) {
    echo "Value of $inputPin is {$inputPin->getValue()}\n";
}
