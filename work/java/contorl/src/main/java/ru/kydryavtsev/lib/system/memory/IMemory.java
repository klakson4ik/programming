package ru.kydryavtsev.lib.system.memory;

public interface IMemory {
    Long getTotal();
    Long getFree();
    Long getUsed();
    Long getSwapTotal();
    Long getSwapFree();
    Long getSwapUsed();
}
