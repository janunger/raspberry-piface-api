<?php

namespace Pkj\Raspberry\PiFace;

use Pkj\Raspberry\PiFace\SpiManager\SpiInterface;

/**
 * Provides common I/O methods for interfacing with PiFace Products
 * Converted from python to php
 *
 * Original python project:
 * https://github.com/piface/pifacecommon
 */
class PiFaceCommon
{
    const WRITE_CMD = 0;
    const READ_CMD = 1;

    // Register addresses
    const IODIRA = 0x0; // I/O direction A
    const IODIRB = 0x1; // I/O direction B
    const IPOLA = 0x2; // I/O polarity A
    const IPOLB = 0x3; // I/O polarity B
    const GPINTENA = 0x4; // interrupt enable A
    const GPINTENB = 0x5; // interrupt enable B
    const DEFVALA = 0x6; // register default value A (interrupts)
    const DEFVALB = 0x7; // register default value B (interrupts)
    const INTCONA = 0x8; // interrupt control A
    const INTCONB = 0x9; // interrupt control B
    const IOCON = 0xA; // I/O config (also 0xB)
    const GPPUA = 0xC; // port A pullups
    const GPPUB = 0xD; // port B pullups
    const INTFA = 0xE; // interrupt flag A (where the interrupt came from)
    const INTFB = 0xF; // interrupt flag B
    const INTCAPA = 0x10; // interrupt capture A (value at interrupt is saved here)
    const INTCAPB = 0x11; // interrupt capture B
    const GPIOA = 0x12; // port A
    const GPIOB = 0x13; // port B

    // I/O config
    const BANK_OFF = 0x00; // addressing mode
    const BANK_ON = 0x80;
    const INT_MIRROR_ON = 0x40; // interrupt mirror (INTa|INTb)
    const INT_MIRROR_OFF = 0x00;
    const SEQOP_OFF = 0x20; // incrementing address pointer
    const SEQOP_ON = 0x20;
    const DISSLW_ON = 0x10; // slew rate
    const DISSLW_OFF = 0x00;
    const HAEN_ON = 0x08; // hardware addressing
    const HAEN_OFF = 0x00;
    const ODR_ON = 0x04; // open drain for interrupts
    const ODR_OFF = 0x00;
    const INTPOL_HIGH = 0x02; // interrupt polarity
    const INTPOL_LOW = 0x00;

    const SPI_IOC_MAGIC = 107;

    const SPIDEV = '/dev/spidev';

    /**
     * @var \Pkj\Raspberry\PiFace\SpiManager\SpiInterface
     */
    private $spi;

    public function __construct(SpiInterface $spi)
    {
        $this->spi = $spi;
    }

    /**
     * @return \Pkj\Raspberry\PiFace\SpiManager\SpiInterface
     */
    public function getSpi()
    {
        return $this->spi;
    }

    /**
     * Translates a pin number to pin bit mask
     * Pin index is zero based, first pin number is 0
     *
     * @return int
     */
    public function getBitMask($bitNum)
    {
        if ($bitNum > 7 || $bitNum < 0) {
            throw new OutOfRangeException(sprintf("Specified bit num (%d) out of range (0-7).", $bitNum));
        }
        return 1 << ($bitNum);
    }

    /**
     * Returns the lowest pin num from a given bit pattern
     *
     * @return int
     */
    public function getBitNum($bitPattern)
    {
        $bitNum = 0; // Assume bit 0
        while ($bitPattern & 1 === 0) {
            $bitPattern = $bitPattern >> 1;
            $bitNum += 1;
            if ($bitNum > 7) {
                $bitNum = 0;
                break;
            }
        }

        return $bitNum;
    }

    /**
     * Returns the bit specified from the address
     *
     * @param int $bitNum
     * @param int $address
     * @param int $boardNum
     * @return int
     */
    public function readBit($bitNum, $address, $boardNum = 0)
    {
        $value = $this->read($address, $boardNum);
        $bitMask = $this->getBitMask($bitNum);

        return $value & $bitMask ? 1 : 0;
    }

    /**
     * @param int $value
     * @param int $bitNum
     * @param int $address
     * @param int $boardNum
     */
    public function writeBit($value, $bitNum, $address, $boardNum)
    {
        $bitMask = $this->getBitMask($bitNum);
        $oldByte = $this->read($address, $boardNum);

        if ($value) {
            $newByte = $oldByte | $bitMask;
        } else {
            $newByte = $oldByte & ~$bitMask;
        }

        $this->write($newByte, $address, $boardNum);
    }

    /**
     * Returns the device opcode (as a byte)
     *
     * @param int $boardNum
     * @param int $readWriteCmd
     * @return int
     */
    public function _getDeviceOpcode($boardNum, $readWriteCmd)
    {
        $boardAddrPattern = ($boardNum << 1) & 0xE; //  0b0010, 3 -> 0b0110
        $rwCmdPattern = $readWriteCmd & 1; // make sure it's just 1 bit long

        return 0x40 | $boardAddrPattern | $rwCmdPattern;
    }

    public function read($address, $boardNum = 0)
    {
        $devopcode = $this->_getDeviceOpcode($boardNum, self::READ_CMD);
        $packet = [$devopcode, $address, 0];
        list($op, $addr, $data) = $this->spi->transfer($packet);

        return $data;
    }

    /**
     * Writes data to the address specified
     *
     * @param int $data
     * @param int $address
     * @param int $boardNum
     * @return int[]
     */
    public function write($data, $address, $boardNum = 0)
    {
        $devopcode = $this->_getDeviceOpcode($boardNum, self::WRITE_CMD);
        $packet = [$devopcode, $address, $data];

        return $this->spi->transfer($packet);
    }
}
