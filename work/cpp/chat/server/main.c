#include "libs/server.h"

int main(int argc, char const *argv[])
{
    int serverFd = initServer();
    startServer(serverFd);
    closeConnect(serverFd);
    return 0;
}
