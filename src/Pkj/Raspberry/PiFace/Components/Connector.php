<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\Driver;
use Pkj\Raspberry\PiFace\PiFace;
use Pkj\Raspberry\PiFace\IndexOutOfRangeException;

abstract class Connector
{
    /**
     * @var \Pkj\Raspberry\PiFace\Driver
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
