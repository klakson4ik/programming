package ru.kydryavtsev.dto;

import io.micronaut.serde.annotation.Serdeable;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.util.List;

@Setter
@Getter
@NoArgsConstructor
@Serdeable
public class BaseDto implements IBaseDto {
    private MemoryDto memory;
    private StorageDto storage;
    private PartitionDto partition;
    private List<PartitionDto> partitions;
}
