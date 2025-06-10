package ru.kudr.api.entity;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.time.LocalDate;

@Getter
@Setter
@Entity
@Table(name = "users")
public class UserEntity {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    private  String name;
    private  String surname;
    @Column(unique = true)
    private  String email;
    private String country;
    private String city;
    private String description;
    private LocalDate dateOfBirth;
}
