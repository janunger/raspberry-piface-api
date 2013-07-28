<?php

use Pkj\Raspberry\PiFace\PiFaceDigital;

require_once __DIR__ . '/../vendor/autoload.php';


$pi = PiFaceDigital::createInstance();
$pi->init();

foreach ($pi->getInputPins() as $inputPin) {
    echo "$inputPin: {$inputPin->getValue()}\n";
}
