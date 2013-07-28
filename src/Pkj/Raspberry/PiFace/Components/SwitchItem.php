<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class SwitchItem extends InputItem
{
    /**
     * @param Driver $driver
     * @param int $switchNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $switchNum, $boardNum = 0)
    {
        if ($switchNum < 0 || $switchNum > 3) {
            throw new IndexOutOfRangeException(sprintf("Specified switch index (%d) out of range.", $switchNum));
        }
        parent::__construct($driver, $switchNum, $boardNum);
    }
}
