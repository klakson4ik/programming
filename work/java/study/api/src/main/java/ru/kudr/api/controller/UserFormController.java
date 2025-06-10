package ru.kudr.api.controller;


import lombok.AllArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import ru.kudr.api.entity.UserEntity;
import ru.kudr.api.service.UserService;

@Controller
//@RequestMapping("/form/users")
@AllArgsConstructor
public class UserFormController {
    private UserService service;

    @PostMapping("/add")
    public String add(@ModelAttribute UserEntity user) {
        service.save(user);
        System.out.print(user.getEmail());
        return "OK";
    }
}
