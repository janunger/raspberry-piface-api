<?php

namespace Pkj\Raspberry\PiFace;

class PiFaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Driver
     */
    private function createDriverMock()
    {
        $spi = $this->getMock('Pkj\Raspberry\PiFace\SpiManager\SpiInterface');

        return new Driver($spi);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnBoardIndexTooHigh()
    {
        new PiFace($this->createDriverMock(), 4);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnBoardIndexTooLow()
    {
        new PiFace($this->createDriverMock(), -1);
    }

    public function testBoardHasEightInputPins()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertCount(8, $sut->getInputPins());
        foreach ($sut->getInputPins() as $inputPin) {
            $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\InputPin', $inputPin);
        }
    }

    public function testBoardHasEightOutputPins()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertCount(8, $sut->getOutputPins());
        foreach ($sut->getOutputPins() as $outputPin) {
            $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\OutputPin', $outputPin);
        }
    }

    public function testBoardHasTwoRelays()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertCount(2, $sut->getRelays());
        foreach ($sut->getRelays() as $relay) {
            $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\OutputPin', $relay);
        }

        $this->assertCount(4, $sut->getSwitches());
    }

    public function testBoardHasFourSwitches()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertCount(4, $sut->getSwitches());
        foreach ($sut->getSwitches() as $switch) {
            $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\InputPin', $switch);
        }
    }

    public function testCanCreateInstancesForValidBoardIndexes()
    {
        foreach (range(0, PiFace::MAX_BOARDS - 1) as $boardIndex) {
            $sut = new PiFace($this->createDriverMock(), $boardIndex);
            $this->assertInstanceOf('Pkj\Raspberry\PiFace\PiFace', $sut);
        }
    }

    public function testCanGetInputPinByIndex()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\InputPin', $sut->getInputPin(0));
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnInputPinIndexTooHigh()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getInputPin(8);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnInputPinIndexTooLow()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getInputPin(-1);
    }

    public function testCanGetOutputPinByIndex()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\OutputPin', $sut->getOutputPin(0));
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnOutputPinIndexTooHigh()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getOutputPin(8);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnOutputPinIndexTooLow()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getOutputPin(-1);
    }

    public function testCanGetRelayByIndex()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\OutputPin', $sut->getRelay(0));
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnRelayIndexTooHigh()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getRelay(2);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnRelayIndexTooLow()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getRelay(-1);
    }

    public function testCanGetSwitchByIndex()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertInstanceOf('\Pkj\Raspberry\PiFace\Components\InputPin', $sut->getSwitch(0));
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnSwitchIndexTooHigh()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getSwitch(4);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnSwitchIndexTooLow()
    {
        $sut = new PiFace($this->createDriverMock());

        $sut->getSwitch(-1);
    }
}
