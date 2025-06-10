#include <iostream>
#include "lib/Server.h"

int main() {
    Address serverAddress{41400, "127.0.0.1"};
    Server server{serverAddress};
    server.bind();
//    Buffer request

    while (1){

    }
    return 0;
}
