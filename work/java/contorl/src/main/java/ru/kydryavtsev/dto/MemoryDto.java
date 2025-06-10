package ru.kydryavtsev.dto;

import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonProperty;
import io.micronaut.serde.annotation.Serdeable;
import lombok.Builder;
import lombok.Value;

@Value
@Builder
@Serdeable
@JsonInclude(JsonInclude.Include.NON_DEFAULT)
public class MemoryDto implements IBaseDto {
    Long total;
    Long free;
    Long used;
    @JsonProperty("swap-total")
    Long swapTotal;
    @JsonProperty("swap-free")
    Long swapFree;
    @JsonProperty("swap-used")
    Long swapUsed;
}
