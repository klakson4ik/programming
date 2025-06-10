package ru.kydryavtsev.service;

import jakarta.inject.Singleton;
import ru.kydryavtsev.dto.IBaseDto;
import ru.kydryavtsev.exception.NotFoundException;
import ru.kydryavtsev.lib.system.Storage.IStorage;
import ru.kydryavtsev.lib.system.Storage.PartitionField;
import ru.kydryavtsev.lib.system.Storage.Storage;
import ru.kydryavtsev.dto.PartitionDto;

import java.util.List;
import java.util.Map;

@Singleton
public class PartitionService {
    final private IStorage storage = new Storage();
    final private PartitionDto partitionDto = new PartitionDto();

    public List<PartitionDto> get(){
        return storage.getPartitions().stream()
                .map(partition -> {
                    PartitionDto dto = new PartitionDto();
                    dto.setAll(partition);
                    return dto;
                })
                .toList();
    }
    public PartitionDto get(Integer numberPartition){
        partitionDto.setAll(getPartition(numberPartition));
        return partitionDto;
    }
    public PartitionDto get(Integer numberPartition, String field){
        PartitionField partitionField;
        try {
            partitionField = PartitionField.get(field);
        } catch (IllegalArgumentException e) {
            throw new NotFoundException("Field not found: " + field);
        }
        partitionDto.set(field, getPartition(numberPartition).get(partitionField));
        return partitionDto;
    }

    private Map<PartitionField,String> getPartition(Integer numberPartition){
        List<Map<PartitionField, String>> partitions = storage.getPartitions();
        if(partitions.size() <= numberPartition) throw new NotFoundException("Partition not found: " + numberPartition);
        return partitions.get(numberPartition);
    }
}
