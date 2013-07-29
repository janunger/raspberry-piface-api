<?php

use Pkj\Raspberry\PiFace\PiFace;

class EndToEndTest extends PHPUnit_Framework_TestCase
{
    public function testEverything()
    {
        $device = PiFace::createInstance();
        $device->init();

        foreach ($device->getRelays() as $relay) {
            $this->assertFalse($relay->isOn());
            $relay->turnOn();
            $this->assertTrue($relay->isOn());
            usleep(200000);
            $relay->turnOff();
            $this->assertFalse($relay->isOn());
            usleep(100000);
        }

        foreach ($device->getOutputPins() as $outputPin) {
            $this->assertFalse($outputPin->isOn());
            $outputPin->turnOn();
            $this->assertTrue($outputPin->isOn());
            usleep(200000);
            $outputPin->turnOff();
            $this->assertFalse($outputPin->isOn());
            usleep(100000);
        }

        foreach ($device->getInputPins() as $inputPin) {
            $this->assertFalse($inputPin->isOn());
        }

        foreach ($device->getSwitches() as $switch) {
            $this->assertFalse($switch->isOn());
        }
    }
}
