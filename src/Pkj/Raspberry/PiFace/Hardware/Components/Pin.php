<?php

namespace Pkj\Raspberry\PiFace\Hardware\Components;

use Pkj\Raspberry\PiFace\Hardware\Driver;

abstract class Pin
{
    /**
     * @var \Pkj\Raspberry\PiFace\Hardware\Driver
     */
    protected $driver;

    /**
     * @var int
     */
    protected $pinIndex;

    /**
     * @var int
     */
    protected $boardIndex;

    /**
     * @param Driver $driver
     * @param int $pinIndex
     * @param int $boardIndex
     * @throws \Pkj\Raspberry\PiFace\IndexOutOfRangeException
     */
    public function __construct(Driver $driver, $pinIndex, $boardIndex = 0)
    {
        $this->driver = $driver;
        $this->boardIndex = $boardIndex;
        $this->pinIndex = $pinIndex;
    }
}
