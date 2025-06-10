package ru.kydryavtsev.service;

import jakarta.inject.Singleton;
import ru.kydryavtsev.exception.NotFoundException;
import ru.kydryavtsev.lib.system.Storage.IStorage;
import ru.kydryavtsev.dto.StorageDto;
import ru.kydryavtsev.lib.system.Storage.Storage;
import ru.kydryavtsev.lib.system.Storage.StorageField;

@Singleton
public class StorageService {
    final private IStorage storage = new Storage();

    public StorageDto get(String field){
        StorageField storageField;
        try {
            storageField = StorageField.get(field);
        } catch (IllegalArgumentException e) {
            throw new NotFoundException("Field not found: " + field);
        }
        return switch (storageField) {
            case StorageField.TOTAL -> getTotal();
            case StorageField.FREE -> getFree();
            case StorageField.USED -> getUsed();
        };
    }

    public StorageDto get(){
        return StorageDto.builder()
                .total(storage.getTotalSpace())
                .free(storage.getFreeSpace())
                .used(storage.getUsedSpace())
                .build();
    }
    public StorageDto getTotal(){
        return StorageDto.builder().total(storage.getTotalSpace()).build();
    }

    public StorageDto getUsed(){
        return StorageDto.builder().used(storage.getUsedSpace()).build();
    }

    public StorageDto getFree(){
        return StorageDto.builder().free(storage.getFreeSpace()).build();
    }
}
