package ru.kydryavtsev.lib.system.Storage;

public enum StorageField {
    TOTAL,
    FREE,
    USED;

    public static StorageField get(String value) throws IllegalArgumentException{
        return valueOf(value.replace("-", "_").toUpperCase());
    }
}
