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

    private $handler;

    private $boardNum;

    private $inputPins = array();
    private $outputPins = array();
    private $leds = array();
    private $relays = array();
    private $switches = array();

    /**
     * Gets all the input pins.
     * @return InputItem[] Array of InputItem
     */
    public function getInputPins()
    {
        return $this->inputPins;
    }

    /**
     * Gets all the output pins.
     * @return OutputItem[]
     */
    public function getOutputPins()
    {
        return $this->outputPins;
    }

    /**
     * Gets all the leds.
     * @return LED[] Array of LED
     */
    public function getLeds()
    {
        return $this->leds;
    }

    /**
     * Gets all the relays.
     * @return Relay[] Array of Relay
     */
    public function getRelays()
    {
        return $this->relays;
    }

    /**
     * Gets all the switches.
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

    /**
     * @return \Pkj\Raspberry\PiFace\PiFaceDigital
     */
    static public function create()
    {
        $spi = new SpiExtension(self::SPI_BUS, self::SPI_CHIP_SELECT);
        $common = new PiFaceCommon($spi);
        return new PiFaceDigital($common);
    }

    /**
     * Creates a new device.
     * @param PiFaceCommon $handler A PiFaceCommon instance.
     * @param int $boardNum Board number.
     */
    public function __construct(PiFaceCommon $handler, $boardNum = 0)
    {
        $this->handler = $handler;

        $this->boardNum = $boardNum;

        // Ranges are +1 for pins.

        foreach (range(0, 7) as $pinNum) {
            $this->inputPins[] = new InputItem($this->handler, ($pinNum), $this->boardNum);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->outputPins[] = new OutputItem($this->handler, ($pinNum), $this->boardNum);
        }

        foreach (range(0, 7) as $pinNum) {
            $this->leds[] = new LED($this->handler, ($pinNum), $this->boardNum);
        }

        foreach (range(0, 1) as $pinNum) {
            $this->relays[] = new Relay($this->handler, ($pinNum), $this->boardNum);
        }

        foreach (range(0, 3) as $pinNum) {
            $this->switches[] = new SwitchItem($this->handler, ($pinNum), $this->boardNum);
        }
    }

    /**
     * Initialises the PiFace Digital board
     * @param bool $initBoard
     * @throws \Exception
     */
    public function init($initBoard = true)
    {
        if ($initBoard) {
            // Setup each board
            $ioconfig = PiFaceCommon::BANK_OFF |
                PiFaceCommon::INT_MIRROR_OFF |
                PiFaceCommon::SEQOP_ON |
                PiFaceCommon::DISSLW_OFF |
                PiFaceCommon::HAEN_ON |
                PiFaceCommon::ODR_OFF |
                PiFaceCommon::INTPOL_LOW;

            $pfdDetected = false;

            foreach (range(0, self::MAX_BOARDS) as $boardIndex) {
                $this->handler->write($ioconfig, PiFaceCommon::IOCON, $boardIndex);

                if (!$pfdDetected) {
                    if ($this->handler->read(PiFaceCommon::IOCON, $boardIndex) == $ioconfig) {
                        $pfdDetected = true;
                    }
                }

                $this->handler->write(0, PiFaceCommon::GPIOA, $boardIndex);
                $this->handler->write(0, PiFaceCommon::IODIRA, $boardIndex);
                $this->handler->write(0xff, PiFaceCommon::IODIRB, $boardIndex);
                $this->handler->write(0xff, PiFaceCommon::GPPUB, $boardIndex);
            }

            if (!$pfdDetected) {
                throw new \Exception ("No piface board detected.");
            }
        }
    }
}
