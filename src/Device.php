<?php
namespace WindTunnel\DummyDevice;

use Evenement\EventEmitterTrait;

class Device
{
    use EventEmitterTrait;

    protected $powerOn = false;
    protected $lastValue = 0;
    protected $fluctuation = 1;
    protected $frequency = 1;

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
        $this->lastValue += deg2rad($this->frequency);
        return sin($this->lastValue) + (mt_rand(-10, 10) / (int)$this->fluctuation);
    }

    public function setFluctuation($fluctuation)
    {
        $fluctuation = (int) $fluctuation;
        if ($fluctuation === 0) {
            $fluctuation = 1;
        }
        $this->fluctuation = $fluctuation;
        $this->emit('fluctuation.changed', [$fluctuation]);
        return $this;
    }

    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
        $this->emit('frequency.changed', [$frequency]);
        return $this;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }

    public function getFluctuation()
    {
        return $this->fluctuation;
    }
}
