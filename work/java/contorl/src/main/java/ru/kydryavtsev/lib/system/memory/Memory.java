package ru.kydryavtsev.lib.system.memory;

import oshi.SystemInfo;
import oshi.hardware.GlobalMemory;
import oshi.hardware.HardwareAbstractionLayer;

public class Memory implements IMemory {
    SystemInfo systemInfo = new SystemInfo();
    HardwareAbstractionLayer hardware = systemInfo.getHardware();
    GlobalMemory memory = hardware.getMemory();

    @Override
    public Long getTotal(){
        return memory.getTotal();
    }

    @Override
    public Long getFree() { return memory.getAvailable(); }

    @Override
    public Long getUsed(){
        return  this.getTotal() - this.getFree();
    }

    @Override
    public  Long getSwapTotal() {
        return memory.getVirtualMemory().getSwapTotal();
    }
    @Override
    public  Long getSwapUsed() {
        return memory.getVirtualMemory().getSwapUsed();
    }

    @Override
    public Long getSwapFree() {
        return this.getSwapTotal() - this.getSwapUsed();
    }
}
