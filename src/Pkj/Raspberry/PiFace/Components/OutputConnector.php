<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;

class OutputConnector extends Connector
{
    /**
     * @return int
     */
    public function getValue()
    {
        return $this->driver->readBit($this->pinNumber, PiFace::OUTPUT_PORT, $this->boardNumber);
    }

    /**
     * @param $data
     */
    public function setValue($data)
    {
        $this->driver->writeBit($data, $this->pinNumber, PiFace::OUTPUT_PORT, $this->boardNumber);
    }

    public function turnOn()
    {
        $this->setValue(1);
    }

    public function turnOff()
    {
        $this->setValue(0);
    }

    public function toggle()
    {
        $this->setValue(!$this->getValue());
    }
}
