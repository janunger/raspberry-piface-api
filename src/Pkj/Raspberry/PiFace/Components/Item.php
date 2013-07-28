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
    protected $pinNum;

    /**
     * @var int
     */
    protected $boardNum;

    /**
     * @param Driver $driver
     * @param int $pinNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $pinNum, $boardNum = 0)
    {
        $this->driver = $driver;

        if ($boardNum < 0 || $boardNum > PiFace::MAX_BOARDS) {
            throw new IndexOutOfRangeException(sprintf("Specified board index (%d) out of range.", $boardNum));
        }

        $this->boardNum = $boardNum;
        $this->pinNum = $pinNum;
    }
}
