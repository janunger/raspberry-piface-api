<?php

use Pkj\Raspberry\PiFace\Emulator\PiFace;
use Pkj\Raspberry\PiFace\Emulator\StateProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$dataDir = new SplFileInfo(__DIR__ . '/emulator_data');
$stateProvider = new StateProvider($dataDir);
$emulator = new PiFace($stateProvider);

foreach ($emulator->getInputPins() as $index => $inputPin) {
    echo "Input $index: " . ($inputPin->isOn() ? "on" : "off") . "\n";
}

foreach ($emulator->getOutputPins() as $index => $outputPin) {
    $outputPin->turnOn();
    echo "Output $index: " . ($outputPin->isOn() ? "on" : "off") . "\n";
}

foreach ($emulator->getOutputPins() as $index => $outputPin) {
    $outputPin->turnOff();
    echo "Output $index: " . ($outputPin->isOn() ? "on" : "off") . "\n";
}
