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
        $driver = new Driver($spi);
        return $driver;
    }

    public function testBoardHasExactMatchOfComponents()
    {
        $sut = new PiFace($this->createDriverMock());

        $this->assertCount(8, $sut->getInputPins());
        $this->assertCount(8, $sut->getOutputPins());
        $this->assertCount(8, $sut->getLeds());
        $this->assertCount(2, $sut->getRelays());
        $this->assertCount(4, $sut->getSwitches());
    }

    public function testCanCreateInstancesForValidBoardNumbers()
    {
        foreach (range(0, PiFace::MAX_BOARDS - 1) as $boardNumber) {
            $sut = new PiFace($this->createDriverMock(), $boardNumber);
            $this->assertInstanceOf('Pkj\Raspberry\PiFace\PiFace', $sut);
        }
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnBoardNumberTooHigh()
    {
        new PiFace($this->createDriverMock(), 4);
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testThrowsExceptionOnBoardNumberTooLow()
    {
        new PiFace($this->createDriverMock(), -1);
    }
}
