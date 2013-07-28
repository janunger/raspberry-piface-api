<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class SwitchItem extends InputConnector
{
    /**
     * @param Driver $driver
     * @param int $switchIndex
     * @param int $boardIndex
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $switchIndex, $boardIndex = 0)
    {
        if ($switchIndex < 0 || $switchIndex > 3) {
            throw new IndexOutOfRangeException("Specified switch index ($switchIndex) out of range.");
        }
        parent::__construct($driver, $switchIndex, $boardIndex);
    }
}
