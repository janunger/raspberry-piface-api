<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class LED extends OutputConnector
{
    /**
     * @param Driver $driver
     * @param int $ledNumber
     * @param int $boardNumber
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $ledNumber, $boardNumber = 0)
    {
        if ($ledNumber < 0 || $ledNumber > 7) {
            throw new IndexOutOfRangeException(sprintf("Specified LED index (%d) out of range.", $ledNumber));
        }
        parent::__construct($driver, $ledNumber, $boardNumber);
    }
}
