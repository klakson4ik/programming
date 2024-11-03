CC=gcc
LIBS=libs/*.c proto/*.c apps/*.c

.PHONY: build and run
default: build
s-udp: server-udp
c-udp: client-udp
c-udp-r: client-udp-raw
c-udp-g: client-udp-game

build:
	$(CC) -D DEV -g server/server-udp.c $(LIBS) -lm -o out/server-udp

server-udp:
	$(CC) -D DEV -g server/server-udp.c $(LIBS) -lm -o out/server-udp && ./out/server-udp
	
client-udp:
	$(CC) -D DEV -g client/client-udp.c $(LIBS) -lm -o out/client-udp && ./out/client-udp

client-udp-raw:
	$(CC) -D DEV -g client/client-udp-raw.c $(LIBS) -lm -o out/client-udp-raw && ./out/client-udp-raw

client-udp-game:
	$(CC) -D DEV -g client/client-udp-game.c $(LIBS) -lm -o out/client-udp-game && ./out/client-udp-game