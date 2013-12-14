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
}
