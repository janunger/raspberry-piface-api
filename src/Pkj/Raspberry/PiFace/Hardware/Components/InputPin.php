<?php

namespace Pkj\Raspberry\PiFace\Hardware\Components;

use Pkj\Raspberry\PiFace\Hardware\PiFace;

class InputPin extends Pin
{
    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->getValue() === 1;
    }

    /**
     * @return int
     */
    private function getValue()
    {
        return 1 ^ $this->driver->readBit($this->pinIndex, PiFace::INPUT_PORT, $this->boardIndex);
    }
}
