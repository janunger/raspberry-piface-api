<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;
use Pkj\Raspberry\PiFace\OutOfRangeException;

class SwitchItem extends InputItem
{
    /**
     * @param PiFaceCommon $handler
     * @param int $switchNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\OutOfRangeException
     */
    public function __construct(PiFaceCommon $handler, $switchNum, $boardNum = 0)
    {
        if ($switchNum < 0 || $switchNum > 3) {
            throw new OutOfRangeException(sprintf("Specified switch index (%d) out of range.", $switchNum));
        }
        parent::__construct($handler, $switchNum, $boardNum);
    }
}
