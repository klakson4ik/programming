//
// Created by kudryavtsev on 20.02.25.
//

#include <cstring>
#include "Server.h"


Server::Server(Address addr) {
    this->addr = addr;
    sd = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP);
    if(sd < 0){
        cerr << "Failed to create socket descriptor: " << strerror(errno) << endl;
        exit(EXIT_FAILURE);
    }
}

void Server::bind() {
    cout << addr.getAddr().sin_addr.s_addr << endl << addr.getPort() << endl <<  sizeof(addr)<< endl;
    if(::bind(sd, (struct  sockaddr*)&addr, sizeof(addr)) < 0) {
        cerr << "Bind error: " << strerror(errno) << endl;;
        exit(EXIT_FAILURE);
    }
}

void Server::listen() {
    ::listen(sd, 5);
}

unsigned int Server::recvFrom(int sd, Address addr, Buffer buffer) {
    return recvfrom(sd, buffer.getMsg(), 32000, 0,
             (struct sockaddr *)&addr.getAddr(), &addr.length);
}
