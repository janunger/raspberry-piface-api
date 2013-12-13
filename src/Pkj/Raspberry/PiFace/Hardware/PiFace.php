<?php

namespace Pkj\Raspberry\PiFace\Hardware;

use Pkj\Raspberry\PiFace\Hardware\Components\InputPin;
use Pkj\Raspberry\PiFace\Hardware\Components\OutputPin;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;
use Pkj\Raspberry\PiFace\Hardware\SpiManager\SpiExtension;

class PiFace implements \Pkj\Raspberry\PiFace
{
    const OUTPUT_PORT = Driver::GPIOA;
    const INPUT_PORT = Driver::GPIOB;
    const INPUT_PULLUP = Driver::GPPUB;
    const MAX_BOARDS = 4;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var int
     */
    private $boardIndex;

    /**
     * @var \Pkj\Raspberry\PiFace\InputPin[]
     */
    private $inputPins = array();

    /**
     * @var \Pkj\Raspberry\PiFace\OutputPin[]
     */
    private $outputPins = array();

    /**
     * @var \Pkj\Raspberry\PiFace\OutputPin[]
     */
    private $relays = array();

    /**
     * @var \Pkj\Raspberry\PiFace\InputPin[]
     */
    private $switches = array();

    /**
     * @param int $boardIndex
     * @return \Pkj\Raspberry\PiFace
     */
    public static function createInstance($boardIndex = 0)
    {
        $spi = new SpiExtension(Driver::SPI_BUS, Driver::SPI_CHIP_SELECT);
        $common = new Driver($spi);

        return new PiFace($common, $boardIndex);
    }

    /**
     * Creates a new device
     *
     * @param Driver $driver
     * @param int $boardIndex
     * @throws IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $boardIndex = 0)
    {
        if ($boardIndex < 0 || $boardIndex > self::MAX_BOARDS - 1) {
            throw new IndexOutOfRangeException("Specified board index ($boardIndex) out of range.");
        }

        $this->driver = $driver;
        $this->boardIndex = $boardIndex;

        foreach (range(0, 7) as $pinIndex) {
            $this->inputPins[] = new InputPin($this->driver, $pinIndex, $this->boardIndex);
        }

        foreach (range(0, 7) as $pinIndex) {
            $this->outputPins[] = new OutputPin($this->driver, $pinIndex, $this->boardIndex);
        }

        $this->relays = array_slice($this->outputPins, 0, 2);
        $this->switches = array_slice($this->inputPins, 0, 4);
    }

    /**
     * Initialises the PiFace Digital board
     *
     * @throws \Exception
     */
    public function init()
    {
        $ioconfig =
            Driver::BANK_OFF |
            Driver::INT_MIRROR_OFF |
            Driver::SEQOP_ON |
            Driver::DISSLW_OFF |
            Driver::HAEN_ON |
            Driver::ODR_OFF |
            Driver::INTPOL_LOW;

        $pfdDetected = false;

        foreach (range(0, self::MAX_BOARDS - 1) as $boardIndex) {
            $this->driver->write($ioconfig, Driver::IOCON, $boardIndex);

            if (!$pfdDetected) {
                if ($this->driver->read(Driver::IOCON, $boardIndex) == $ioconfig) {
                    $pfdDetected = true;
                }
            }

            $this->driver->write(0, Driver::GPIOA, $boardIndex);
            $this->driver->write(0, Driver::IODIRA, $boardIndex);
            $this->driver->write(0xff, Driver::IODIRB, $boardIndex);
            $this->driver->write(0xff, Driver::GPPUB, $boardIndex);
        }

        if (!$pfdDetected) {
            throw new InitException("No PiFace board detected");
        }
    }

    /**
     * @return \Pkj\Raspberry\PiFace\InputPin[]
     */
    public function getInputPins()
    {
        return $this->inputPins;
    }

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\InputPin
     * @throws IndexOutOfRangeException
     */
    public function getInputPin($index)
    {
        if (!isset($this->inputPins[$index])) {
            throw new IndexOutOfRangeException("No input pin by index ($index)");
        }

        return $this->inputPins[$index];
    }

    /**
     * @return \Pkj\Raspberry\PiFace\OutputPin[]
     */
    public function getOutputPins()
    {
        return $this->outputPins;
    }

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\OutputPin
     * @throws IndexOutOfRangeException
     */
    public function getOutputPin($index)
    {
        if (!isset($this->outputPins[$index])) {
            throw new IndexOutOfRangeException("No output pin by index ($index)");
        }

        return $this->outputPins[$index];
    }

    /**
     * @return \Pkj\Raspberry\PiFace\OutputPin[]
     */
    public function getRelays()
    {
        return $this->relays;
    }

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\OutputPin
     * @throws IndexOutOfRangeException
     */
    public function getRelay($index)
    {
        if (!isset($this->relays[$index])) {
            throw new IndexOutOfRangeException("No relay by index ($index)");
        }

        return $this->relays[$index];
    }

    /**
     * @return \Pkj\Raspberry\PiFace\InputPin[]
     */
    public function getSwitches()
    {
        return $this->switches;
    }

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\InputPin
     * @throws IndexOutOfRangeException
     */
    public function getSwitch($index)
    {
        if (!isset($this->switches[$index])) {
            throw new IndexOutOfRangeException("No switch by index ($index)");
        }

        return $this->switches[$index];
    }
}
