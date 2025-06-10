package ru.kydryavtsev.controller;

import io.micronaut.http.annotation.Controller;
import io.micronaut.http.annotation.Get;
import lombok.RequiredArgsConstructor;
import ru.kydryavtsev.dto.BaseDto;
import ru.kydryavtsev.service.MainService;


@RequiredArgsConstructor
@Controller("/")
public class MainController {
    private final MainService mainService;
    @Get("/")
    public BaseDto index(){
        return mainService.get();
    }
}
