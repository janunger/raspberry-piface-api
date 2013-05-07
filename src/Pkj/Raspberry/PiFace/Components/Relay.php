<?php
namespace Pkj\Raspberry\PiFace\Components;
use Pkj\Raspberry\PiFace\PiFaceCommon;
use Pkj\Raspberry\PiFace\PiFaceDigital;
use Pkj\Raspberry\PiFace\RangeError;


class Relay extends OutputItem {
	public function __construct(PiFaceCommon $handler, $relayNum, $boardNum = 0) {
		if ($relayNum < 0 || $relayNum > 1) {
			throw new RangeError(sprintf("Specified relay index (%d) out of range.", $relayNum));
		}
		parent::__construct($handler, $relayNum, $boardNum);
	}
}

