<?php

namespace Pkj\Raspberry\PiFace\Emulator\Components;

use Pkj\Raspberry\PiFace\Emulator\StateProvider;

abstract class Pin
{

    /**
     * @var StateProvider
     */
    protected $stateProvider;
    /**
     * @var int
     */
    protected $pinIndex;
    /**
     * @var int
     */
    protected $boardIndex;

    public function __construct(StateProvider $stateProvider, $pinIndex, $boardIndex = 0)
    {
        $this->stateProvider = $stateProvider;
        $this->pinIndex = $pinIndex;
        $this->boardIndex = $boardIndex;
    }
}
