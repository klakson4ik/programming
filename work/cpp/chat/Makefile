CC=clang
LIBS_SERVER=server/libs/*.c
LIBS_CLIENT=client/libs/*.c
PORT=8443

.PHONY: build server and run
default: buildServer runServer

.PHONY: build client and run
client: buildClient runClient

buildServer: 
	$(CC) -Wall -g server/main.c $(LIBS_SERVER) -o server/main 

buildClient:
	$(CC) -Wall -g client/main.c $(LIBS_CLIENT) -o client/main

runServer: 
	./server/main

runClient: 
	./client/main 127.0.0.1 $(PORT)