<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;

class InputConnector extends Connector
{
    /**
     * @return int
     */
    public function getValue()
    {
        return 1 ^ $this->driver->readBit($this->pinIndex, PiFace::INPUT_PORT, $this->boardIndex);
    }
}
