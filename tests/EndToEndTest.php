<?php

use Pkj\Raspberry\PiFace\PiFaceDigital;

class EndToEndTest extends PHPUnit_Framework_TestCase
{
    public function testEverything()
    {
        $device = PiFaceDigital::create();
        $device->init();

        foreach ($device->getRelays() as $relay) {
            $this->assertEquals(0, $relay->getValue());
            $relay->turnOn();
            $this->assertEquals(1, $relay->getValue());
            usleep(300000);
            $relay->turnOff();
            $this->assertEquals(0, $relay->getValue());
            usleep(100000);
        }

        foreach ($device->getLeds() as $led) {
            $this->assertEquals(0, $led->getValue());
            $led->turnOn();
            $this->assertEquals(1, $led->getValue());
            usleep(300000);
            $led->turnOff();
            $this->assertEquals(0, $led->getValue());
            usleep(100000);
        }

        foreach ($device->getOutputPins() as $outputPin) {
            $this->assertEquals(0, $outputPin->getValue());
            $outputPin->turnOn();
            $this->assertEquals(1, $outputPin->getValue());
            usleep(300000);
            $outputPin->turnOff();
            $this->assertEquals(0, $outputPin->getValue());
            usleep(100000);
        }

        foreach ($device->getInputPins() as $inputPin) {
            $this->assertEquals(0, $inputPin->getValue());
        }
        
        foreach ($device->getSwitches() as $switch) {
            $this->assertEquals(0, $switch->getValue());
        }
    }
}
