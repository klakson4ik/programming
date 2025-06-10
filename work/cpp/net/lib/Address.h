//
// Created by kudryavtsev on 20.02.25.
//

#ifndef NET_ADDRESS_H
#define NET_ADDRESS_H

#include <netinet/in.h>
#include <iostream>

using namespace std;

class Address {
public:
    socklen_t length;
    Address(int port, const char* ip);

    Address();

    const sockaddr_in &getAddr() const;


    int getPort() const;

private:
    sockaddr_in addr;
    int port;
};


#endif //NET_ADDRESS_H
