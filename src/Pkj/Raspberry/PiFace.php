<?php

namespace Pkj\Raspberry;

use Pkj\Raspberry\PiFace\IndexOutOfRangeException;
use Pkj\Raspberry\PiFace\InputPin;
use Pkj\Raspberry\PiFace\OutputPin;

interface PiFace
{
    /**
     * Initialises the PiFace Digital board
     *
     * @throws \Pkj\Raspberry\PiFace\Hardware\InitException
     */
    public function init();

    /**
     * @return InputPin[]
     */
    public function getInputPins();

    /**
     * @param int $index
     * @return InputPin
     * @throws IndexOutOfRangeException
     */
    public function getInputPin($index);

    /**
     * @return OutputPin[]
     */
    public function getOutputPins();

    /**
     * @param int $index
     * @return OutputPin
     * @throws IndexOutOfRangeException
     */
    public function getOutputPin($index);

    /**
     * @return OutputPin[]
     */
    public function getRelays();

    /**
     * @param int $index
     * @return OutputPin
     * @throws IndexOutOfRangeException
     */
    public function getRelay($index);

    /**
     * @return InputPin[]
     */
    public function getSwitches();

    /**
     * @param int $index
     * @return InputPin
     * @throws IndexOutOfRangeException
     */
    public function getSwitch($index);
}
