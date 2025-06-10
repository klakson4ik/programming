//
// Created by kudryavtsev on 20.02.25.
//

#ifndef NET_SERVER_H
#define NET_SERVER_H

#include <netinet/in.h>
#include <iostream>
#include "Address.h"
#include "Buffer.h"

using namespace std;

class Server {
    int sd;
    Address addr;

public:
    Server(Address addr);
    void bind();
    void listen();
    unsigned int recvFrom(int sd, Address addr, Buffer buffer);


};


#endif //NET_SERVER_H
