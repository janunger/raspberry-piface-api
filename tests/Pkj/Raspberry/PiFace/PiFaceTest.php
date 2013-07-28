<?php

namespace Pkj\Raspberry\PiFace;

class PiFaceTest extends \PHPUnit_Framework_TestCase
{
    protected function createSUT()
    {
        $spi = $this->getMock('Pkj\Raspberry\PiFace\SpiManager\SpiInterface');
        $common = new Driver($spi);

        return new PiFace($common);
    }

    public function testBoardHasExactMatchOfComponents()
    {
        $p = $this->createSUT();

        $this->assertCount(8, $p->getInputPins());
        $this->assertCount(8, $p->getOutputPins());
        $this->assertCount(8, $p->getLeds());
        $this->assertCount(2, $p->getRelays());
        $this->assertCount(4, $p->getSwitches());
    }
}
