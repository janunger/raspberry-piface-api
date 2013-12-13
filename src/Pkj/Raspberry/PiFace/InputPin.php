<?php

namespace Pkj\Raspberry\PiFace;

interface InputPin
{
    /**
     * @return bool
     */
    public function isOn();
}
