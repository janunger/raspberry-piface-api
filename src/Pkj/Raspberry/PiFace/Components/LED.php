<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class LED extends OutputItem
{
    /**
     * @param Driver $driver
     * @param int $ledNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $ledNum, $boardNum = 0)
    {
        if ($ledNum < 0 || $ledNum > 7) {
            throw new IndexOutOfRangeException(sprintf("Specified LED index (%d) out of range.", $ledNum));
        }
        parent::__construct($driver, $ledNum, $boardNum);
    }
}
