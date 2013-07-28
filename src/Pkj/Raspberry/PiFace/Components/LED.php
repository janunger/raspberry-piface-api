<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class LED extends OutputConnector
{
    /**
     * @param Driver $driver
     * @param int $ledIndex
     * @param int $boardIndex
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $ledIndex, $boardIndex = 0)
    {
        if ($ledIndex < 0 || $ledIndex > 7) {
            throw new IndexOutOfRangeException(sprintf("Specified LED index (%d) out of range.", $ledIndex));
        }
        parent::__construct($driver, $ledIndex, $boardIndex);
    }
}
