<?php

namespace Pkj\Raspberry;

use Pkj\Raspberry\PiFace\IndexOutOfRangeException;
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
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\InputPin[]
     */
    public function getInputPins();

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\InputPin
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
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\InputPin[]
     */
    public function getSwitches();

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\InputPin
     * @throws IndexOutOfRangeException
     */
    public function getSwitch($index);
}
