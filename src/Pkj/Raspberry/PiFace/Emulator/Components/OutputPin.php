<?php

namespace Pkj\Raspberry\PiFace\Emulator\Components;

class OutputPin extends Pin implements \Pkj\Raspberry\PiFace\OutputPin
{
    private $isOn = false;

    public function turnOff()
    {
        $this->stateProvider->writeOutput($this->pinIndex, $this->boardIndex, 0);
    }

    public function turnOn()
    {
        $this->stateProvider->writeOutput($this->pinIndex, $this->boardIndex, 1);
    }

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->stateProvider->readOutput($this->pinIndex, $this->boardIndex) === 1;
    }

    public function toggle()
    {
        if ($this->isOn()) {
            $this->turnOff();
        } else {
            $this->turnOn();
        }
    }
}
