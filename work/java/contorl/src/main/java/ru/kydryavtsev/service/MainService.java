package ru.kydryavtsev.service;

import jakarta.inject.Singleton;
import ru.kydryavtsev.dto.BaseDto;

@Singleton
public class MainService {
    public BaseDto get(){
        BaseDto baseDto = new BaseDto();
        baseDto.setMemory(new MemoryService().get());
        baseDto.setStorage(new StorageService().get());
        baseDto.setPartitions(new PartitionService().get());
        return baseDto;
    }
}
