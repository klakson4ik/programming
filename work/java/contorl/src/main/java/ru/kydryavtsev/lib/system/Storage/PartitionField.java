package ru.kydryavtsev.lib.system.Storage;

import ru.kydryavtsev.exception.NotFoundException;

public enum PartitionField {
    NAME,
    MOUNT,
    TYPE,
    DESCRIPTION,
    LABEL,
    VOLUME,
    LOGICAL_VOLUME,
    OPTIONS,
    UUID,
    TOTAL_SPACE,
    FREE_SPACE,
    USED_SPACE,
    TOTAL_NODES,
    FREE_NODES;

    public static PartitionField get(String value) throws IllegalArgumentException{
        return valueOf(value.replace("-", "_").toUpperCase());
    }
}
