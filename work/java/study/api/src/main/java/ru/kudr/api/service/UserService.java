package ru.kudr.api.service;

import ru.kudr.api.entity.UserEntity;

import java.util.Optional;

public interface UserService {
    Iterable<UserEntity> findAll();
    UserEntity save(UserEntity user);
    Optional<UserEntity> findById(Long id);
    UserEntity update(UserEntity user);
    void delete(UserEntity user);

}
