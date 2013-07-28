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
    private $boardNumber;

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
     * @param int $boardNumber
     * @return \Pkj\Raspberry\PiFace\PiFace
     */
    public static function createInstance($boardNumber = 0)
    {
        $spi = new SpiExtension(Driver::SPI_BUS, Driver::SPI_CHIP_SELECT);
        $common = new Driver($spi);

        return new PiFace($common, $boardNumber);
    }

    /**
     * Creates a new device
     *
     * @param Driver $driver
     * @param int $boardNumber
     * @throws IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $boardNumber = 0)
    {
        if ($boardNumber < 0 || $boardNumber > self::MAX_BOARDS - 1) {
            throw new IndexOutOfRangeException("Specified board index ($boardNumber) out of range.");
        }

        $this->driver = $driver;
        $this->boardNumber = $boardNumber;

        foreach (range(0, 7) as $pinNumber) {
            $this->inputPins[] = new InputConnector($this->driver, ($pinNumber), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNumber) {
            $this->outputPins[] = new OutputConnector($this->driver, ($pinNumber), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNumber) {
            $this->leds[] = new LED($this->driver, ($pinNumber), $this->boardNumber);
        }

        foreach (range(0, 1) as $pinNumber) {
            $this->relays[] = new Relay($this->driver, ($pinNumber), $this->boardNumber);
        }

        foreach (range(0, 3) as $pinNumber) {
            $this->switches[] = new SwitchItem($this->driver, ($pinNumber), $this->boardNumber);
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

        foreach (range(0, self::MAX_BOARDS) as $boardNumber) {
            $this->driver->write($ioconfig, Driver::IOCON, $boardNumber);

            if (!$pfdDetected) {
                if ($this->driver->read(Driver::IOCON, $boardNumber) == $ioconfig) {
                    $pfdDetected = true;
                }
            }

            $this->driver->write(0, Driver::GPIOA, $boardNumber);
            $this->driver->write(0, Driver::IODIRA, $boardNumber);
            $this->driver->write(0xff, Driver::IODIRB, $boardNumber);
            $this->driver->write(0xff, Driver::GPPUB, $boardNumber);
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
