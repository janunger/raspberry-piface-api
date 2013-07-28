<?php

namespace Pkj\Raspberry\PiFace;

use Pkj\Raspberry\PiFace\Components\InputItem;
use Pkj\Raspberry\PiFace\Components\LED;
use Pkj\Raspberry\PiFace\Components\OutputItem;
use Pkj\Raspberry\PiFace\Components\Relay;
use Pkj\Raspberry\PiFace\Components\SwitchItem;
use Pkj\Raspberry\PiFace\SpiManager\SpiExtension;

class PiFaceDigital
{
    const OUTPUT_PORT = PiFaceCommon::GPIOA;
    const INPUT_PORT = PiFaceCommon::GPIOB;
    const INPUT_PULLUP = PiFaceCommon::GPPUB;
    const MAX_BOARDS = 4;

    // /dev/spidev<bus>.<chipselect>
    const SPI_BUS = 0;
    const SPI_CHIP_SELECT = 0;

    /**
     * @var PiFaceCommon
     */
    private $handler;

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
     * @return \Pkj\Raspberry\PiFace\PiFaceDigital
     */
    static public function createInstance()
    {
        $spi = new SpiExtension(self::SPI_BUS, self::SPI_CHIP_SELECT);
        $common = new PiFaceCommon($spi);

        return new PiFaceDigital($common);
    }

    /**
     * Creates a new device
     *
     * @param PiFaceCommon $handler
     * @param int $boardNumber
     */
    public function __construct(PiFaceCommon $handler, $boardNumber = 0)
    {
        $this->handler = $handler;
        $this->boardNumber = $boardNumber;

        foreach (range(0, 7) as $pinNum) {
            $this->inputPins[] = new InputItem($this->handler, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->outputPins[] = new OutputItem($this->handler, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->leds[] = new LED($this->handler, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 1) as $pinNum) {
            $this->relays[] = new Relay($this->handler, ($pinNum), $this->boardNumber);
        }

        foreach (range(0, 3) as $pinNum) {
            $this->switches[] = new SwitchItem($this->handler, ($pinNum), $this->boardNumber);
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
            PiFaceCommon::BANK_OFF |
            PiFaceCommon::INT_MIRROR_OFF |
            PiFaceCommon::SEQOP_ON |
            PiFaceCommon::DISSLW_OFF |
            PiFaceCommon::HAEN_ON |
            PiFaceCommon::ODR_OFF |
            PiFaceCommon::INTPOL_LOW;

        $pfdDetected = false;

        foreach (range(0, self::MAX_BOARDS) as $boardNumber) {
            $this->handler->write($ioconfig, PiFaceCommon::IOCON, $boardNumber);

            if (!$pfdDetected) {
                if ($this->handler->read(PiFaceCommon::IOCON, $boardNumber) == $ioconfig) {
                    $pfdDetected = true;
                }
            }

            $this->handler->write(0, PiFaceCommon::GPIOA, $boardNumber);
            $this->handler->write(0, PiFaceCommon::IODIRA, $boardNumber);
            $this->handler->write(0xff, PiFaceCommon::IODIRB, $boardNumber);
            $this->handler->write(0xff, PiFaceCommon::GPPUB, $boardNumber);
        }

        if (!$pfdDetected) {
            throw new \Exception ("No PiFace board detected");
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

    public function getHandler()
    {
        return $this->handler;
    }
}
