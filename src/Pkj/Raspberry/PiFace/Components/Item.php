<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;
use Pkj\Raspberry\PiFace\OutOfRangeException;

abstract class Item
{
    /**
     * @var \Pkj\Raspberry\PiFace\PiFaceCommon
     */
    protected $handler;

    /**
     * @var int
     */
    protected $pinNum;

    /**
     * @var int
     */
    protected $boardNum;

    /**
     * @param PiFaceCommon $handler
     * @param int $pinNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\OutOfRangeException
     */
    public function __construct(PiFaceCommon $handler, $pinNum, $boardNum = 0)
    {
        $this->handler = $handler;

        if ($boardNum < 0 || $boardNum > PiFaceDigital::MAX_BOARDS) {
            throw new OutOfRangeException(sprintf("Specified board index (%d) out of range.", $boardNum));
        }

        $this->boardNum = $boardNum;
        $this->pinNum = $pinNum;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "PiFace Component: Board {$this->boardNum}, Pin {$this->pinNum}";
    }
}
