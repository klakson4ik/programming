package ru.kydryavtsev.service;

import io.micronaut.http.HttpRequest;
import io.micronaut.http.HttpResponse;
import io.micronaut.http.client.HttpClient;
import io.micronaut.http.client.annotation.Client;
import io.micronaut.test.extensions.junit5.annotation.MicronautTest;
import jakarta.inject.Inject;
import org.junit.jupiter.api.Test;
import ru.kydryavtsev.dto.BaseDto;
import ru.kydryavtsev.dto.MemoryDto;

@MicronautTest
class MemoryServiceTest {

    @Inject
    @Client("/")
    HttpClient client;

    @Test
    void get() {
        HttpRequest<?> request = HttpRequest.GET("/memory");
        HttpResponse<BaseDto> response = client.toBlocking().exchange(request, BaseDto.class);
        MemoryDto memoryDto = response.body().getMemory();

//        System.out.println("Total memory: " + memoryDto);
    }

    @Test
    void getTotal() {
    }

    @Test
    void getFree() {
    }

    @Test
    void getUsed() {
    }

    @Test
    void getSwapTotal() {
    }

    @Test
    void getSwapFree() {
    }

    @Test
    void getSwapUsed() {
    }
}