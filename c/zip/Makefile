CC=clang
LIBS=libs/*.c

.PHONY: build server and run
default: build run

build:
	$(CC) -Wall -g main.c $(LIBS) -lm -o main

run:
	./main text.txt