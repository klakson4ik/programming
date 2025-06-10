package ru.kydryavtsev.exception;


import io.micronaut.serde.annotation.Serdeable;
import lombok.Value;

@Value
@Serdeable.Serializable
public class ErrorResponse {
    String code;
    String path;
    String message;

    public ErrorResponse(String code, String message, String path) {
        this.code = code;
        this.message = message;
        this.path = path;
    }
}
