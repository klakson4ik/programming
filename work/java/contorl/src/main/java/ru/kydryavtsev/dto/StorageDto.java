package ru.kydryavtsev.dto;

import io.micronaut.serde.annotation.Serdeable;
import lombok.Builder;
import lombok.Value;

@Builder
@Value
@Serdeable
public class StorageDto implements IBaseDto {
    Long total;
    Long used;
    Long free;
}
