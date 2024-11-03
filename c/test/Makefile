CC=clang
LIBS=libs/array/*.c
INCLUDES=config.h

.PHONY: build and run
default: dev run
prod: prod run

dev:
	$(CC) -D DEV -include $(INCLUDES) -g main.c $(LIBS) -lm -o main

prod:
	$(CC) -Wall -O2 -include $(INCLUDES) -g main.c $(LIBS) -lm -o main

run:
	./main