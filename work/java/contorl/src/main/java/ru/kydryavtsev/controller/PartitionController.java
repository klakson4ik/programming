package ru.kydryavtsev.controller;

import io.micronaut.http.annotation.Controller;
import io.micronaut.http.annotation.Get;
import io.micronaut.http.annotation.PathVariable;
import lombok.RequiredArgsConstructor;
import ru.kydryavtsev.dto.BaseDto;
import ru.kydryavtsev.service.BaseService;

@RequiredArgsConstructor
@Controller("/partition")
public class PartitionController {
    private final BaseService baseService;

    @Get("/")
    public BaseDto index(){
        return baseService.getPartition();
    }
    @Get("/{partition}")
    public BaseDto index(@PathVariable Integer partition){
        return baseService.getPartition(partition);
    }
    @Get("/{partition}/{field}")
    public BaseDto index(
        @PathVariable Integer partition,
        @PathVariable String field
        ){
        return baseService.getPartition(partition, field);
    }
}
