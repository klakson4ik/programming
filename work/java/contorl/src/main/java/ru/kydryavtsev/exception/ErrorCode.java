package ru.kydryavtsev.exception;

public enum ErrorCode {
    INTERNAL_SERVER_ERROR,
    INVALID_REQUEST,

    RESOURCE_NOT_FOUND,
    RESOURCE_ALREADY_EXISTS,

    VALIDATION_FAILED,

    UNAUTHORIZED,
    FORBIDDEN
}