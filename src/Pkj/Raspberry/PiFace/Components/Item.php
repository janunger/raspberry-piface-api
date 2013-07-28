<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

abstract class Item
{
    /**
     * @var \Pkj\Raspberry\PiFace\Driver
     */
    protected $driver;

    /**
     * @var int
     */
    protected $pinNumber;

    /**
     * @var int
     */
    protected $boardNumber;

    /**
     * @param Driver $driver
     * @param int $pinNumber
     * @param int $boardNumber
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $pinNumber, $boardNumber = 0)
    {
        $this->driver = $driver;

        if ($boardNumber < 0 || $boardNumber > PiFace::MAX_BOARDS) {
            throw new IndexOutOfRangeException(sprintf("Specified board index (%d) out of range.", $boardNumber));
        }

        $this->boardNumber = $boardNumber;
        $this->pinNumber = $pinNumber;
    }
}
