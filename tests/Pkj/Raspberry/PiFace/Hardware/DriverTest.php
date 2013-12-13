<?php

namespace Pkj\Raspberry\PiFace\Hardware;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    protected function createSUT()
    {
        $spi = $this->getMock('Pkj\Raspberry\PiFace\Hardware\SpiManager\SpiInterface');

        return new Driver($spi);
    }

    public function testGetBitMask()
    {
        $sut = $this->createSUT();

        $this->assertEquals(0x2, $sut->getBitMask(1));
        $this->assertEquals(0x4, $sut->getBitMask(2));
        $this->assertEquals(0x8, $sut->getBitMask(3));
        $this->assertEquals(0x10, $sut->getBitMask(4));
    }

    /**
     * @expectedException \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function testGetBitMaskException()
    {
        $sut = $this->createSUT();

        $sut->getBitMask(8);
    }

    public function testWrite()
    {
        $spi = $this->getMock(
            'Pkj\Raspberry\PiFace\Hardware\SpiManager\FileSpiManager',
            array('transfer'),
            array(0, 0)
        );

        $sut = new Driver($spi);

        $packet = [
            $sut->getDeviceOpcode(0, Driver::WRITE_CMD),
            Driver::GPPUB,
            0xFF
        ];

        $spi->expects($this->once())
            ->method('transfer')
            ->with($packet);

        $sut->write(0xFF, Driver::GPPUB, 0);
    }

    public function testRead()
    {
        $spi = $this->getMock(
            'Pkj\Raspberry\PiFace\Hardware\SpiManager\FileSpiManager',
            array('transfer'),
            array(0, 0)
        );

        $c = new Driver($spi);

        $spi->expects($this->once())
            ->method('transfer')
            ->will($this->returnValue(array(null, null, 0xFF)));

        $this->assertEquals(0XFF, $c->read(Driver::GPPUB, 2));
    }
}
