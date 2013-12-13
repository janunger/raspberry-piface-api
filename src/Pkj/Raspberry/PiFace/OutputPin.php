<?php

namespace Pkj\Raspberry\PiFace;

interface OutputPin
{
    public function turnOff();

    public function turnOn();

    /**
     * @return bool
     */
    public function isOn();

    public function toggle();
}
