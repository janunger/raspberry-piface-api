<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class Relay extends OutputItem
{
    /**
     * @param Driver $driver
     * @param int $relayNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $relayNum, $boardNum = 0)
    {
        if ($relayNum < 0 || $relayNum > 1) {
            throw new IndexOutOfRangeException(sprintf("Specified relay index (%d) out of range.", $relayNum));
        }
        parent::__construct($driver, $relayNum, $boardNum);
    }
}
