<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

class Relay extends OutputConnector
{
    /**
     * @param Driver $driver
     * @param int $relayIndex
     * @param int $boardIndex
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $relayIndex, $boardIndex = 0)
    {
        if ($relayIndex < 0 || $relayIndex > 1) {
            throw new IndexOutOfRangeException(sprintf("Specified relay index (%d) out of range.", $relayIndex));
        }
        parent::__construct($driver, $relayIndex, $boardIndex);
    }
}
