package ru.kydryavtsev.service;

import io.micronaut.runtime.http.scope.RequestScope;
import ru.kydryavtsev.dto.BaseDto;

@RequestScope
public class BaseService {
    private final BaseDto baseDto = new BaseDto();

    public BaseDto getMemory(){
        baseDto.setMemory(new MemoryService().get());
        return baseDto;
    }

    public BaseDto getMemory(String field){
        baseDto.setMemory(new MemoryService().get(field));
        return baseDto;
    }

    public BaseDto getStorage(){
        baseDto.setStorage(new StorageService().get());
        return baseDto;
    }

    public BaseDto getStorage(String field){
        baseDto.setStorage(new StorageService().get(field));
        return baseDto;
    }

    public BaseDto getPartition(){
        baseDto.setPartitions(new PartitionService().get());
        return baseDto;
    }

    public BaseDto getPartition(Integer partition){
        baseDto.setPartition(new PartitionService().get(partition));
        return baseDto;
    }

    public BaseDto getPartition(Integer partition, String field){
        baseDto.setPartition(new PartitionService().get(partition, field));
        return baseDto;
    }
}
