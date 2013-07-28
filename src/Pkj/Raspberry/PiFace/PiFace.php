<?php

namespace Pkj\Raspberry\PiFace;

use Pkj\Raspberry\PiFace\Components\InputConnector;
use Pkj\Raspberry\PiFace\Components\LED;
use Pkj\Raspberry\PiFace\Components\OutputConnector;
use Pkj\Raspberry\PiFace\Components\Relay;
use Pkj\Raspberry\PiFace\Components\SwitchItem;
use Pkj\Raspberry\PiFace\SpiManager\SpiExtension;

class PiFace
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
     * @var InputConnector[]
     */
    private $inputPins = array();

    /**
     * @var OutputConnector[]
     */
    private $outputPins = array();

    /**
     * @var LED[]
     */
    private $leds = array();

    /**
     * @var Relay[]
     */
    private $relays = array();

    /**
     * @var SwitchItem[]
     */
    private $switches = array();

    /**
     * @param int $boardIndex
     * @return \Pkj\Raspberry\PiFace\PiFace
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
            $this->inputPins[] = new InputConnector($this->driver, ($pinIndex), $this->boardIndex);
        }

        foreach (range(0, 7) as $pinIndex) {
            $this->outputPins[] = new OutputConnector($this->driver, ($pinIndex), $this->boardIndex);
        }

        foreach (range(0, 7) as $pinIndex) {
            $this->leds[] = new LED($this->driver, ($pinIndex), $this->boardIndex);
        }

        foreach (range(0, 1) as $pinIndex) {
            $this->relays[] = new Relay($this->driver, ($pinIndex), $this->boardIndex);
        }

        foreach (range(0, 3) as $pinIndex) {
            $this->switches[] = new SwitchItem($this->driver, ($pinIndex), $this->boardIndex);
        }
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

        foreach (range(0, self::MAX_BOARDS) as $boardIndex) {
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
     * @return InputConnector[]
     */
    public function getInputPins()
    {
        return $this->inputPins;
    }

    /**
     * @return OutputConnector[]
     */
    public function getOutputPins()
    {
        return $this->outputPins;
    }

    /**
     * @return LED[]
     */
    public function getLeds()
    {
        return $this->leds;
    }

    /**
     * @return Relay[]
     */
    public function getRelays()
    {
        return $this->relays;
    }

    /**
     * @return SwitchItem[]
     */
    public function getSwitches()
    {
        return $this->switches;
    }
}
