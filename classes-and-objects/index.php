<?php

interface Controllable {
    public function turnOn(): void;
    public function turnOff(): void;
    public function getStatus(): string;
}

trait PowerSave {
    private int $battery = 100;
    public function consumePower(int $amount): void {
        $this->battery = max(0, $this->battery - $amount);
        echo "Battery: {$this->battery}%\n";
    }
}

class SmartDevice implements Controllable {
    use PowerSave;
    
    private bool $isOn = false;
    protected string $name;
    
    public function __construct(string $name) {
        $this->name = $name;
    }
    
    private function setOn(bool $state): void {
        $this->isOn = $state;
    }
    
    public function turnOn(): void {
        $this->setOn(true);
        echo "{$this->name} turned ON.\n";
    }
    
    public function turnOff(): void {
        $this->setOn(false);
        echo "{$this->name} turned OFF.\n";
    }
    
    public function getStatus(): string {
        return $this->isOn ? "ON" : "OFF";
    }
}

class SmartLight extends SmartDevice {
    private int $brightness = 50;
    
    public function setBrightness(int $level): void {
        $this->brightness = max(0, min(100, $level));
        echo "{$this->name} brightness set to {$this->brightness}%\n";
        $this->consumePower(5);
    }
}

$device = new SmartDevice("Socket");
$device->turnOn();
echo "Status: " . $device->getStatus() . "\n";
$device->turnOff();

echo "\n--- Smart Light ---\n";
$light = new SmartLight("Living Room Light");
$light->turnOn();
$light->setBrightness(80);
echo "Status: " . $light->getStatus() . "\n";
$light->consumePower(10);
$light->turnOff();
