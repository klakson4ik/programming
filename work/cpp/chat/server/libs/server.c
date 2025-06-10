#include "stdlib.h"
#include <stdio.h>
#include "arpa/inet.h"
#include <sys/socket.h>
#include <unistd.h>
#include <sys/stat.h>
#include <sys/sendfile.h>
#include "string.h"
#include <fcntl.h>

#define PORT 8443

void error(const char *msg)
{
    perror(msg);
    exit(EXIT_FAILURE);
}

const int initServer()
{
    struct sockaddr_in address = {};
    int serverFd, opt = 1;
    if ((serverFd = socket(AF_INET, SOCK_STREAM, 0)) == 0)
        error("Can't get socket");

    setsockopt(serverFd, SOL_SOCKET, SO_REUSEADDR, (char *)&opt, sizeof(opt));
    address.sin_family = AF_INET;
    address.sin_addr.s_addr = INADDR_ANY;
    address.sin_port = htons(PORT);
    address.sin_zero[0] = '\0';

    if (bind(serverFd, (struct sockaddr *)&address, sizeof(address)) < 0)
        error("Can't bind");

    if (listen(serverFd, SOMAXCONN) < 0)
        error("Can't listen");

    return serverFd;
}

void startServer(const int serverFd)
{
    struct sockaddr_in clientAddr;
    socklen_t clientLen;
    int clientFd = accept(serverFd, (struct sockaddr *)&clientAddr, &clientLen);
    struct in_addr ipAddr = clientAddr.sin_addr;
    char clientIP[INET_ADDRSTRLEN];
    inet_ntop(AF_INET, &ipAddr, clientIP, INET_ADDRSTRLEN);
    printf("IP: %s \n", clientIP);

    char bufferW[4096] = {};
    char bufferR[4096] = {};

    while (1)
    {
        fgets(bufferW, sizeof(bufferW), stdin);
        if (strlen(bufferW) > 0)
        {
            write(clientFd, bufferW, strlen(bufferW));
            bufferW[0] = '\0';
        }
        if (read(clientFd, bufferR, sizeof(bufferR)) > 0)
        {
            printf("%s", bufferR);
            bufferR[0] = '\0';
            write(clientFd, "\0", 1);
        }
    }
    close(clientFd);
}

void closeConnect(const int serverFd){
    close(serverFd);
}