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
        if (null === $session) {
            return;
        }
        $session->register('com.windtunnel.powerOn', [$this->device, 'powerOn']);
        $session->register('com.windtunnel.powerOff', [$this->device, 'powerOff']);
        $session->register('com.windtunnel.powerState', [$this->device, 'powerState']);
        $device = $this->device;
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
