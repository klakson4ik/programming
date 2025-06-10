package ru.kydryavtsev.exception;

public class BadRequestException extends ApiException {
    public BadRequestException(String message) {
        super(ErrorCode.INVALID_REQUEST, message);
    }
}
