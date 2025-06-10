CREATE TABLE IF NOT EXISTS users
(
    id    SERIAL8 PRIMARY KEY ,
    name  VARCHAR(200) NOT NULL ,
    email VARCHAR(254) UNIQUE NOT NULL ,
    phone VARCHAR(30),
    surname VARCHAR(200),
    country VARCHAR(200),
    city VARCHAR(200),
    description VARCHAR(2048)
);