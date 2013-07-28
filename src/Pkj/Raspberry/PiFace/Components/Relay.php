<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class Relay extends OutputItem
{
    /**
     * @param Driver $driver
     * @param int $relayNumber
     * @param int $boardNumber
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $relayNumber, $boardNumber = 0)
    {
        if ($relayNumber < 0 || $relayNumber > 1) {
            throw new IndexOutOfRangeException(sprintf("Specified relay index (%d) out of range.", $relayNumber));
        }
        parent::__construct($driver, $relayNumber, $boardNumber);
    }
}
