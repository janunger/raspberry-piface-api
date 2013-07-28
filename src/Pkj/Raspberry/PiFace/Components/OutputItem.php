<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;

class OutputItem extends Item
{
    /**
     * @return int
     */
    public function getValue()
    {
        return $this->driver->readBit($this->pinNum, PiFace::OUTPUT_PORT, $this->boardNum);
    }

    /**
     * @param $data
     */
    public function setValue($data)
    {
        $this->driver->writeBit($data, $this->pinNum, PiFace::OUTPUT_PORT, $this->boardNum);
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
