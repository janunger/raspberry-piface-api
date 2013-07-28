<?php

namespace Pkj\Raspberry\PiFace;

use Pkj\Raspberry\PiFace\Components\InputItem;
use Pkj\Raspberry\PiFace\Components\LED;
use Pkj\Raspberry\PiFace\Components\OutputItem;
use Pkj\Raspberry\PiFace\Components\Relay;
use Pkj\Raspberry\PiFace\Components\SwitchItem;
use Pkj\Raspberry\PiFace\SpiManager\SpiExtension;

class PiFace
{
    const OUTPUT_PORT = Driver::GPIOA;
    const INPUT_PORT = Driver::GPIOB;
    const INPUT_PULLUP = Driver::GPPUB;
    const MAX_BOARDS = 4;

    // /dev/spidev<bus>.<chipselect>
    const SPI_BUS = 0;
    const SPI_CHIP_SELECT = 0;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var int
     */
    private $boardNumber;

    /**
     * @var InputItem[]
     */
    private $inputPins = array();

    /**
     * @var OutputItem[]
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
        $spi = new SpiExtension(self::SPI_BUS, self::SPI_CHIP_SELECT);
        $common = new Driver($spi);

        return new PiFace($common, $boardNumber);
    }

    /**
     * Creates a new device
     *
     * @param Driver $driver
     * @param int $boardNumber
     */
    public function __construct(Driver $driver, $boardNumber = 0)
    {
        $this->driver = $driver;
        $this->boardNumber = $boardNumber;

        foreach (range(0, 7) as $pinNum) {
            $this->inputPins[] = new InputItem($this->driver, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->outputPins[] = new OutputItem($this->driver, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->leds[] = new LED($this->driver, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 1) as $pinNum) {
            $this->relays[] = new Relay($this->driver, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 3) as $pinNum) {
            $this->switches[] = new SwitchItem($this->driver, ($pinNum), $this->boardNumber);
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
     * @return InputItem[]
     */
    public function getInputPins()
    {
        return $this->inputPins;
    }

    /**
     * @return OutputItem[]
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
