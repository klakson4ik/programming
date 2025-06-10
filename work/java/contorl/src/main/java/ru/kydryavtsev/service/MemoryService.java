package ru.kydryavtsev.service;

import jakarta.inject.Singleton;
import ru.kydryavtsev.exception.NotFoundException;
import ru.kydryavtsev.lib.system.memory.IMemory;
import ru.kydryavtsev.dto.MemoryDto;
import ru.kydryavtsev.lib.system.memory.Memory;
import ru.kydryavtsev.lib.system.memory.MemoryField;

@Singleton
public class MemoryService {
    private final IMemory memory = new Memory();

    public MemoryDto get(String field){
        MemoryField memoryField;
        try {
            memoryField = MemoryField.get(field);
        } catch (IllegalArgumentException e) {
            throw new NotFoundException("Field not found: " + field);
        }
        return switch (memoryField) {
            case MemoryField.TOTAL -> getTotal();
            case MemoryField.FREE -> getFree();
            case MemoryField.USED -> getUsed();
            case MemoryField.SWAP_TOTAL -> getSwapTotal();
            case MemoryField.SWAP_FREE -> getSwapFree();
            case MemoryField.SWAP_USED -> getSwapUsed();
        };
    }

    public MemoryDto get(){
        return MemoryDto.builder()
                .total(memory.getTotal())
                .used(memory.getUsed())
                .free(memory.getFree())
                .swapTotal(memory.getSwapTotal())
                .swapUsed(memory.getSwapUsed())
                .swapFree(memory.getSwapFree())
                .build();
    }
    public MemoryDto getTotal(){
        return MemoryDto.builder().total(memory.getTotal()).build();
    }

    public MemoryDto getFree(){
        return MemoryDto.builder().free(memory.getFree()).build();
    }

    public MemoryDto getUsed(){
        return MemoryDto.builder().used(memory.getUsed()).build();
    }

    public MemoryDto getSwapTotal(){
        return MemoryDto.builder().swapTotal(memory.getSwapTotal()).build();
    }

    public MemoryDto getSwapFree(){
        return MemoryDto.builder().swapFree(memory.getSwapFree()).build();
    }

    public MemoryDto getSwapUsed(){
        return MemoryDto.builder().swapUsed(memory.getSwapUsed()).build();
    }
}