<?php
namespace WindTunnel\DummyDevice;

use Thruway\Peer\Client;

class TunnelClient extends \Thruway\Peer\Client
{
    protected $device;

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        $device = $this->device;

        $session->register('com.windtunnel.powerOn', [$this->device, 'power_on']);
        $session->register('com.windtunnel.powerOff', [$this->device, 'power_off']);
        $session->register('com.windtunnel.powerState', [$this->device, 'power_state']);
        $session->register(
            'com.windtunnel.setfrequency',
            function ($value) use ($device) {
                $device->setFrequency($value[0]);
            }
        );
        $session->register(
            'com.windtunnel.setfluctuation',
            function ($value) use ($device) {
                $device->setFluctuation($value[0]);
            }
        );

        $this->device->on('fluctuation.changed', function ($fluctuation) use ($session, $device) {
            $session->publish('com.windtunnel.fluctuation', [$fluctuation]);
        });
        $this->device->on('frequency.changed', function ($frequency) use ($session, $device) {
            $session->publish('com.windtunnel.frequency', [$frequency]);
        });
        $this->getLoop()->addPeriodicTimer(0.1, function () use ($session, $device) {
            $session->publish('com.windtunnel.data', [$device->getSinData()]);
        });
    }

    public function setDevice(Device $device)
    {
        $this->device = $device;
        return $this;
    }
}
