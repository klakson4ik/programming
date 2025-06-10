//
// Created by kudryavtsev on 20.02.25.
//

#include <arpa/inet.h>
#include "Address.h"

Address::Address(int port, const char* ip) : port(port) {
    addr.sin_port = htons(port);
    addr.sin_family = AF_INET;
    if (inet_pton(AF_INET, ip, &addr.sin_addr) < 0)
    {
        cout << ("Error in DESTINATION IP translation to special numeric format") << endl;
        exit(EXIT_FAILURE);
    }
    this->port = htons(port);
}

Address::Address() {}

const sockaddr_in &Address::getAddr() const {
    return addr;
}

int Address::getPort() const {
    return port;
}
