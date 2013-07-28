<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class SwitchItem extends InputItem
{
    /**
     * @param Driver $driver
     * @param int $switchNumber
     * @param int $boardNumber
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $switchNumber, $boardNumber = 0)
    {
        if ($switchNumber < 0 || $switchNumber > 3) {
            throw new IndexOutOfRangeException(sprintf("Specified switch index (%d) out of range.", $switchNumber));
        }
        parent::__construct($driver, $switchNumber, $boardNumber);
    }
}
