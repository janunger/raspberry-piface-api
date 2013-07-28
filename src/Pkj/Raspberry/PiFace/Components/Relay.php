<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;
use Pkj\Raspberry\PiFace\OutOfRangeException;

class Relay extends OutputItem
{
    /**
     * @param PiFaceCommon $handler
     * @param int $relayNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\OutOfRangeException
     */
    public function __construct(PiFaceCommon $handler, $relayNum, $boardNum = 0)
    {
        if ($relayNum < 0 || $relayNum > 1) {
            throw new OutOfRangeException(sprintf("Specified relay index (%d) out of range.", $relayNum));
        }
        parent::__construct($handler, $relayNum, $boardNum);
    }
}
