<?php

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;

require __DIR__ . '/../vendor/autoload.php';


if (!class_exists('\Spi')) {
    die ("Spi extension must be installed (https://github.com/frak/php_spi)");
}

$dev = PiFace::createInstance();
$dev->init();

foreach ($dev->getRelays() as $key => $relay) {
    echo "Turning on relay: $key\n";
    $relay->turnOn();
    usleep(300000);
    echo "Turning off relay: $key\n";
    $relay->turnOff();
    usleep(300000);
}

foreach ($dev->getOutputPins() as $key => $pin) {
    echo "Turning on led: $key\n";
    $pin->turnOn();
    usleep(300000);
    echo "Turning off led: $key\n";
    $pin->turnOff();
    usleep(300000);
}

foreach ($dev->getInputPins() as $key => $inputPin) {
    echo "Value of input $key is " .  ($inputPin->isOn() ? 'on' : 'off') . "\n";
}
