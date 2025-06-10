package ru.kydryavtsev.lib.system.Storage;

import java.util.List;
import java.util.Map;

public interface IStorage {
    Long getTotalSpace();
    Long getFreeSpace();
    Long getUsedSpace();

    List<Map<PartitionField, String>> getPartitions();
}
