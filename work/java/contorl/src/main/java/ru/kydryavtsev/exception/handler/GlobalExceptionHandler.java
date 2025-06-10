package ru.kydryavtsev.exception.handler;

import io.micronaut.context.annotation.Requires;
import io.micronaut.http.HttpRequest;
import io.micronaut.http.HttpResponse;
import io.micronaut.http.HttpStatus;
import io.micronaut.http.annotation.Produces;
import io.micronaut.http.server.exceptions.ExceptionHandler;
import jakarta.inject.Singleton;
import ru.kydryavtsev.exception.ApiException;
import ru.kydryavtsev.exception.ErrorResponse;

@Produces
@Singleton
@Requires(classes = {ApiException.class, ExceptionHandler.class})
public class GlobalExceptionHandler implements ExceptionHandler<ApiException, HttpResponse<ErrorResponse>> {

    @Override
    public HttpResponse<ErrorResponse> handle(HttpRequest request, ApiException exception) {
        ErrorResponse errorResponse = new ErrorResponse(
                exception.getErrorCode().name(),
                exception.getMessage(),
                request.getPath()
        );

        return HttpResponse.status(getStatus(exception))
                .body(errorResponse);
    }

    private HttpStatus getStatus(ApiException exception) {
        // Здесь можно добавить логику определения статуса по типу исключения
        return HttpStatus.BAD_REQUEST;
    }
}
