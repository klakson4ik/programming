package ru.kudr.api.controller;


import lombok.AllArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import ru.kudr.api.entity.UserEntity;
import ru.kudr.api.service.UserService;

@RestController
@RequestMapping("/api/v1/users")
@AllArgsConstructor
public class UserController {
    private UserService service;

    @GetMapping
    public Iterable<UserEntity> findAll() {
        return service.findAll();
    }

    @PostMapping("/add")
    public UserEntity add(@RequestBody UserEntity user) {
        return service.save(user);
    }
}
