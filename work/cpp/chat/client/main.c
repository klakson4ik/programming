#include <netinet/in.h>
#include "libs/client.h"

int main(int argc, char const *argv[])
{
    struct sockaddr_in address = {};
    int serverFd = initServer(&address, argv);
    startConnect(address, serverFd);
    closeConnect(serverFd);
    return 0;
}
