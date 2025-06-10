package ru.kydryavtsev.lib.system.memory;

public enum MemoryField {
    TOTAL,
    FREE,
    USED,
    SWAP_TOTAL,
    SWAP_FREE,
    SWAP_USED;

    public static MemoryField get(String value) throws IllegalArgumentException{
        return valueOf(value.replace("-", "_").toUpperCase());
    }
}
