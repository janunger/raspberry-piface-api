<?php

namespace Pkj\Raspberry\PiFace\Hardware\Components;

use Pkj\Raspberry\PiFace\Hardware\PiFace;

class OutputPin extends Pin implements \Pkj\Raspberry\PiFace\OutputPin
{
    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->getValue() === 1;
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

    /**
     * @return int
     */
    private function getValue()
    {
        return $this->driver->readBit($this->pinIndex, PiFace::OUTPUT_PORT, $this->boardIndex);
    }

    /**
     * @param $data
     */
    private function setValue($data)
    {
        $this->driver->writeBit($data, $this->pinIndex, PiFace::OUTPUT_PORT, $this->boardIndex);
    }
}
