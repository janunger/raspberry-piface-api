<?php

namespace Pkj\Raspberry\PiFace\Emulator;

use Pkj\Raspberry\PiFace\Hardware\PiFace as PiFaceHardware;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;
use Pkj\Raspberry\PiFace\InputPin;
use Pkj\Raspberry\PiFace\OutputPin;

class PiFace implements \Pkj\Raspberry\PiFace
{
    /**
     * @var int
     */
    private $boardIndex;

    /**
     * @var InputPin[]
     */
    private $inputPins;

    /**
     * @var OutputPin[]
     */
    private $outputPins;

    public function __construct(StateProvider $stateProvider, $boardIndex = 0)
    {
        if ($boardIndex < 0 || $boardIndex > PiFaceHardware::MAX_BOARDS - 1) {
            throw new IndexOutOfRangeException("Specified board index ($boardIndex) out of range.");
        }

        $this->boardIndex = $boardIndex;

        foreach (range(0, 7) as $pinIndex) {
            $this->inputPins[] = new Components\InputPin($stateProvider, $pinIndex, $boardIndex);
        }

        foreach (range(0, 7) as $pinIndex) {
            $this->outputPins[] = new Components\OutputPin($stateProvider, $pinIndex, $boardIndex);
        }

        $this->relays = array_slice($this->outputPins, 0, 2);
        $this->switches = array_slice($this->inputPins, 0, 4);
    }

    /**
     * Initialises the PiFace Digital board
     *
     * @throws \Pkj\Raspberry\PiFace\Hardware\InitException
     */
    public function init()
    {}

    /**
     * @return InputPin[]
     */
    public function getInputPins()
    {
        return $this->inputPins;
    }

    /**
     * @param int $index
     * @return InputPin
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
     * @return OutputPin[]
     */
    public function getOutputPins()
    {
        return $this->outputPins;
    }

    /**
     * @param int $index
     * @return OutputPin
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
     * @return OutputPin[]
     */
    public function getRelays()
    {
        return $this->relays;
    }

    /**
     * @param int $index
     * @return OutputPin
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
     * @return InputPin[]
     */
    public function getSwitches()
    {
        return $this->switches;
    }

    /**
     * @param int $index
     * @return InputPin
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
