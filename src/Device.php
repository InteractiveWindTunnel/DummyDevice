<?php
namespace WindTunnel\DummyDevice;

class Device
{
    protected $powerOn = false;
    protected $lastValue = 0;

    public function powerOn()
    {
        $this->powerOn = true;
        return $this;
    }

    public function powerOff()
    {
        $this->powerOn = false;
    }

    public function isPowerOn()
    {
        return $this->powerOn;
    }

    public function getSinData()
    {
        $this->lastValue += 0.017453;
        return sin($this->lastValue) + (mt_rand(-10, 10)/20);
    }
}
