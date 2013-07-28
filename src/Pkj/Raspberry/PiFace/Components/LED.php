<?php

namespace Pkj\Raspberry\PiFace\Components;

use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;
use Pkj\Raspberry\PiFace\OutOfRangeException;

class LED extends OutputItem
{
    /**
     * @param PiFaceCommon $handler
     * @param int $ledNum
     * @param int $boardNum
     * @throws \Pkj\Raspberry\PiFace\OutOfRangeException
     */
    public function __construct(PiFaceCommon $handler, $ledNum, $boardNum = 0)
    {
        if ($ledNum < 0 || $ledNum > 7) {
            throw new OutOfRangeException(sprintf("Specified LED index (%d) out of range.", $ledNum));
        }
        parent::__construct($handler, $ledNum, $boardNum);
    }
}
