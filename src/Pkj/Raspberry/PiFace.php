<?php

namespace Pkj\Raspberry;

use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

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
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\OutputPin[]
     */
    public function getOutputPins();

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\OutputPin
     * @throws IndexOutOfRangeException
     */
    public function getOutputPin($index);

    /**
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\OutputPin[]
     */
    public function getRelays();

    /**
     * @param int $index
     * @return \Pkj\Raspberry\PiFace\Hardware\Components\OutputPin
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
