#ifndef CURLY_SOCKET
#define CURLY_SOCKET

#include "struct.h"

uint32_t get_socket(const uint32_t type, const uint32_t proto);
void bind_socket(const uint32_t socket, const Stct stct);

uint32_t get_udp_socket();
uint32_t get_raw_socket();
#endif