<?php

use Pkj\Raspberry\PiFace\PiFace;

require_once __DIR__ . '/../vendor/autoload.php';


$pi = PiFace::createInstance();
$pi->init();

foreach ($pi->getInputPins() as $inputPin) {
    echo "$inputPin: {$inputPin->getValue()}\n";
}
