package ru.kydryavtsev.controller;

import io.micronaut.http.annotation.Controller;
import io.micronaut.http.annotation.Get;
import io.micronaut.http.annotation.PathVariable;
import lombok.RequiredArgsConstructor;
import ru.kydryavtsev.dto.BaseDto;
import ru.kydryavtsev.service.BaseService;

@RequiredArgsConstructor
@Controller("/memory")
public class MemoryController {
    private final BaseService baseService;

    @Get("/")
    public BaseDto index(){
        return baseService.getMemory();
    }

    @Get("/{field}")
    public BaseDto index(@PathVariable String field){
        return baseService.getMemory(field);
    }
}
