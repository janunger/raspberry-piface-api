<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;

class InputItem extends Item
{
    /**
     * @return int
     */
    public function getValue()
    {
        return 1 ^ $this->driver->readBit($this->pinNum, PiFace::INPUT_PORT, $this->boardNum);
    }
}
