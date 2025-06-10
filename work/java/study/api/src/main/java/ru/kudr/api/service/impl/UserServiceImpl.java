package ru.kudr.api.service.impl;

import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;
import ru.kudr.api.entity.UserEntity;
import ru.kudr.api.repository.UserRepository;
import ru.kudr.api.service.UserService;

import java.util.Optional;

@Service
@AllArgsConstructor
public class UserServiceImpl implements UserService {

    private final UserRepository repository;

    @Override
    public Iterable<UserEntity> findAll() {
        return repository.findAll();
    }

    @Override
    public UserEntity save(UserEntity user) {
        return repository.save(user);
    }

    @Override
    public Optional<UserEntity> findById(Long id) {
        return repository.findById(id);
    }

    @Override
    public UserEntity update(UserEntity user) {
        return repository.save(user);
    }

    @Override
    public void delete(UserEntity user) {
        repository.delete(user);
    }
}
