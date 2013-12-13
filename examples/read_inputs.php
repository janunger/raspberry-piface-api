<?php

use Pkj\Raspberry\PiFace\PiFace;

require_once __DIR__ . '/../vendor/autoload.php';


$pi = PiFace::createInstance();
$pi->init();

foreach ($pi->getInputPins() as $index => $inputPin) {
    echo "$index: " . ($inputPin->isOn() ? "on" : "off") . "\n";
}
