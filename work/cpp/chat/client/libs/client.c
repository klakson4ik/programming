#include "stdlib.h"
#include <stdio.h>
#include "arpa/inet.h"
#include <sys/socket.h>
#include <unistd.h>
#include <string.h>
#include <netdb.h>

void error(const char *msg)
{
    perror(msg);
    exit(0);
}

const int initServer(struct sockaddr_in *address, char const *argv[])
{
    if (!argv[1])
        error("hosting not specified");

    if (!argv[2])
        error("Port not specified");

    unsigned short port;
    int serverFd;
    struct hostent *server;

    serverFd = socket(AF_INET, SOCK_STREAM, 0);

    if (serverFd < 0)
        error("ERROR opening socket");

    server = gethostbyname(argv[1]);
    if (server == NULL)
        error("hosting not found");

    port = (unsigned short)atoi(argv[2]);
    bzero((char *)address, sizeof(address));
    address->sin_family = AF_INET;
    address->sin_addr.s_addr = *((unsigned long *)server->h_addr);
    address->sin_port = htons(port);

    return serverFd;
}

void startConnect(struct sockaddr_in address, const int serverFd)
{
    char bufferW[4096] = {};
    char bufferR[4096] = {};

    if (connect(serverFd, (struct sockaddr *)&address, sizeof(address)) < 0)
        error("ERROR connecting");
    while (1)
    {
        fgets(bufferW, sizeof(bufferW), stdin);
        if (strlen(bufferW) > 1)
        {
            write(serverFd, bufferW, strlen(bufferW));
            bufferW[0] = '\0';
        }
        if (read(serverFd, bufferR, sizeof(bufferR)) > 0)
        {
            printf("%s", bufferR);
            bufferR[0] = '\0';
            write(serverFd, "\0", 1);
        }
    }
}

void closeConnect(const int serverFd)
{
    close(serverFd);
}