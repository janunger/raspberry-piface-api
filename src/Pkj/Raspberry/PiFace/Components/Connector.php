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
        $this->boardNumber = $boardNumber;
        $this->pinNumber = $pinNumber;
    }
}
