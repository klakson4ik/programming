package ru.kydryavtsev.lib.system.Storage;

import oshi.SystemInfo;
import oshi.hardware.HWDiskStore;
import oshi.hardware.HWPartition;
import oshi.software.os.OSFileStore;

import java.util.*;
import java.util.stream.Collectors;

public class Storage implements IStorage{
    private final List<OSFileStore> realFileStores = new ArrayList<>();

    public Storage(){
        SystemInfo systemInfo = new SystemInfo();
        List<OSFileStore> fileStores = systemInfo.getOperatingSystem().getFileSystem().getFileStores();
        Set<String> volumes = new HashSet<>();
        Set<String> diskUuids = systemInfo.getHardware().getDiskStores().stream()
                .flatMap(diskStore -> diskStore.getPartitions().stream())
                .map(HWPartition::getUuid)
                .collect(Collectors.toSet());
        fileStores.stream()
                .filter(fileStore -> diskUuids.contains(fileStore.getUUID()))
                .filter(fileStore -> volumes.add(fileStore.getVolume()))
                .forEach(realFileStores::add);
    }

    @Override
    public Long getTotalSpace(){
        return realFileStores.stream()
                .mapToLong(OSFileStore::getTotalSpace)
                .sum();
    }

    @Override
    public Long getUsedSpace() {
        return realFileStores.stream()
                .mapToLong(OSFileStore::getUsableSpace)
                .sum();
    }

    @Override
    public Long getFreeSpace() {
        return realFileStores.stream()
                .mapToLong(OSFileStore::getFreeSpace)
                .sum();
    }

    @Override
    public List<Map<PartitionField, String>> getPartitions(){
        return realFileStores.stream()
                .map(fileStore -> {
                            Map<PartitionField, String> map = new HashMap<>();
                            map.put(PartitionField.NAME, fileStore.getName());
                            map.put(PartitionField.MOUNT, fileStore.getMount());
                            map.put(PartitionField.TYPE, fileStore.getType());
                            map.put(PartitionField.DESCRIPTION, fileStore.getDescription());
                            map.put(PartitionField.LABEL, fileStore.getLabel());
                            map.put(PartitionField.VOLUME, fileStore.getVolume());
                            map.put(PartitionField.LOGICAL_VOLUME, fileStore.getLogicalVolume());
                            map.put(PartitionField.OPTIONS, fileStore.getOptions());
                            map.put(PartitionField.UUID, fileStore.getUUID());
                            map.put(PartitionField.TOTAL_SPACE, String.valueOf(fileStore.getTotalSpace()));
                            map.put(PartitionField.FREE_SPACE, String.valueOf(fileStore.getFreeSpace()));
                            map.put(PartitionField.USED_SPACE, String.valueOf(fileStore.getUsableSpace()));
                            map.put(PartitionField.TOTAL_NODES, String.valueOf(fileStore.getTotalInodes()));
                            map.put(PartitionField.FREE_NODES, String.valueOf(fileStore.getFreeInodes()));
                            return map;
                        })
                .collect(Collectors.toList());
    }
}