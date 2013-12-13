<?php

namespace Pkj\Raspberry\PiFace\Hardware\SpiManager;

use Pkj\Raspberry\PiFace\Hardware\SpiManager\SpiInterface;

class SpiExtension implements SpiInterface
{
    /**
     * @var \Spi
     */
    private $spi;

    public function __construct($bus, $chipselect, array $options = array())
    {
        $this->spi = new \Spi($bus, $chipselect, $options);
    }

    public function transfer(array $data)
    {
        return $this->spi->transfer($data);
    }

    public function blockTransfer(array $data, $colDelay = 1, $disregard = false)
    {
        return $this->spi->blockTransfer($data, $colDelay, $disregard);
    }
}
