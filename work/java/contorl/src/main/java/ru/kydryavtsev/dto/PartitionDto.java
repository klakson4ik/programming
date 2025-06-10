package ru.kydryavtsev.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import io.micronaut.serde.annotation.Serdeable;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import ru.kydryavtsev.lib.system.Storage.PartitionField;

import java.util.Map;

@Getter
@Setter
@Serdeable
@NoArgsConstructor
public class PartitionDto implements IBaseDto {
    private String name;
    private String mount;
    private String type;
    private String label;
    private String description;
    @JsonProperty("logical-volume")
    private String logicalVolume;
    private String options;
    private String uuid;
    private String volume;
    @JsonProperty("total-nodes")
    private Long totalNodes;
    @JsonProperty("free-nodes")
    private Long freeNodes;
    @JsonProperty("total-space")
    private Long totalSpace;
    @JsonProperty("free-space")
    private Long freeSpace;
    @JsonProperty("used-space")
    private Long usedSpace;

    public void set(String field, String value) {
        switch (PartitionField.get(field)) {
            case NAME          -> name = value;
            case MOUNT          -> mount = value;
            case TYPE           -> type = value;
            case LABEL          -> label = value;
            case DESCRIPTION    -> description = value;
            case LOGICAL_VOLUME -> logicalVolume = value;
            case OPTIONS        -> options = value;
            case UUID           -> uuid = value;
            case VOLUME         -> volume = value;
            case TOTAL_NODES -> totalNodes = Long.valueOf(value);
            case FREE_NODES -> freeNodes = Long.valueOf(value);
            case TOTAL_SPACE -> totalSpace = Long.valueOf(value);
            case FREE_SPACE -> freeSpace = Long.valueOf(value);
            case USED_SPACE -> usedSpace = Long.valueOf(value);
            default -> throw new IllegalArgumentException("Unknown field: " + field);
        }
    }

    public void setAll(Map<PartitionField, String> partition){
        name = partition.get(PartitionField.NAME);
        mount = partition.get(PartitionField.MOUNT);
        type  = partition.get(PartitionField.TYPE);
        label = partition.get(PartitionField.LABEL);
        description = partition.get(PartitionField.DESCRIPTION);
        logicalVolume = partition.get(PartitionField.LOGICAL_VOLUME);
        options = partition.get(PartitionField.OPTIONS);
        uuid = partition.get(PartitionField.UUID);
        volume = partition.get(PartitionField.VOLUME);
        totalNodes = Long.valueOf(partition.get(PartitionField.TOTAL_NODES));
        freeNodes = Long.valueOf(partition.get(PartitionField.FREE_NODES));
        totalSpace = Long.valueOf(partition.get(PartitionField.TOTAL_SPACE));
        freeSpace = Long.valueOf(partition.get(PartitionField.FREE_SPACE));
        usedSpace = Long.valueOf(partition.get(PartitionField.USED_SPACE));
    }
}
