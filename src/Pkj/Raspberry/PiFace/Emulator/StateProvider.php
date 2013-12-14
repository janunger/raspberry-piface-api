<?php

namespace Pkj\Raspberry\PiFace\Emulator;

class StateProvider
{
    /**
     * @var \SplFileInfo
     */
    private $dataDir;

    public function __construct(\SplFileInfo $dataDir)
    {
        $this->dataDir = $dataDir;
    }

    public function readInput($pinIndex, $boardIndex)
    {
        $dataFile = $this->createInputDataFileInfo($pinIndex, $boardIndex);
        if (!$dataFile->isFile()) {
            file_put_contents($dataFile->getPathname(), '0');
        }

        return (int)file_get_contents($dataFile->getPathname());
    }

    public function writeInput($pinIndex, $boardIndex, $value)
    {
        $dataFile = $this->createInputDataFileInfo($pinIndex, $boardIndex);
        file_put_contents($dataFile->getPathname(), ($value ? '1' : '0'));
    }

    /**
     * @param $pinIndex
     * @param $boardIndex
     * @return \SplFileInfo
     */
    private function createInputDataFileInfo($pinIndex, $boardIndex)
    {
        $fileName = sprintf(
            'I-%s-%s',
            $boardIndex,
            $pinIndex
        );
        return new \SplFileInfo($this->dataDir->getPathname() . '/' . $fileName);
    }

    public function readOutput($pinIndex, $boardIndex)
    {
        $dataFile = $this->createOutputDataFileInfo($pinIndex, $boardIndex);
        if (!$dataFile->isFile()) {
            file_put_contents($dataFile->getPathname(), '0');
        }

        return (int)file_get_contents($dataFile->getPathname());
    }

    public function writeOutput($pinIndex, $boardIndex, $value)
    {
        $dataFile = $this->createOutputDataFileInfo($pinIndex, $boardIndex);
        file_put_contents($dataFile->getPathname(), ($value ? '1' : '0'));
    }

    /**
     * @param $pinIndex
     * @param $boardIndex
     * @return \SplFileInfo
     */
    private function createOutputDataFileInfo($pinIndex, $boardIndex)
    {
        $fileName = sprintf(
            'O-%s-%s',
            $boardIndex,
            $pinIndex
        );
        return new \SplFileInfo($this->dataDir->getPathname() . '/' . $fileName);
    }
}
