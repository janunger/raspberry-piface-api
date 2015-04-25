<?php

namespace Pkj\Raspberry\PiFace\Emulator\Components;

class InputPin extends Pin implements \Pkj\Raspberry\PiFace\InputPin
{
    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->stateProvider->readInput($this->pinIndex, $this->boardIndex) === 1;
    }

    /**
     * @param bool $flag
     */
    public function setIsOn($flag)
    {
        $this->stateProvider->writeInput($this->pinIndex, $this->boardIndex, $flag ? 1 : 0);
    }
}
