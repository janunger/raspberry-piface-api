<?php

namespace Pkj\Raspberry\PiFace\SpiManager;

interface SpiInterface
{
    /**
     * Should open an SPI in dev
     *
     * @param int $bus The bus
     * @param int $chipselect What chip.
     * @param array $options
     */
    public function __construct($bus, $chipselect, array $options = array());

    /**
     * Transfers array of data
     * Should return the result
     *
     * @param int[] $data
     */
    public function transfer(array $data);

    /**
     * Should transfer a block stream of data
     *
     * @param int[] $data
     * @param int $colDelay
     * @param bool $disregard
     */
    public function blockTransfer(array $data, $colDelay = 1, $disregard = false);
}
