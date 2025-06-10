cmake_minimum_required(VERSION 3.28)
project(net)

set(CMAKE_CXX_STANDARD 20)

add_executable(net main.cpp
        lib/Server.cpp
        lib/Server.h
        lib/Buffer.cpp
        lib/Buffer.h
        lib/Address.cpp
        lib/Address.h)
