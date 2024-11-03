#include "struct.h"
#include <stdio.h>
#include <stdlib.h>

uint32_t get_socket(const uint32_t type, const uint32_t proto) {
  uint32_t socketd = socket(AF_INET, type, proto);
  if (socketd < 0) {
    perror("Failed to create raw socket");
    exit(EXIT_FAILURE);
  }
  return socketd;
}

void bind_socket(const uint32_t socket, const Stct stct) {
  if (bind(socket, (const struct sockaddr *)&stct.addr, stct.addr_len) < 0) {
    perror("bind failed");
    exit(EXIT_FAILURE);
  }
}

uint32_t get_udp_socket() { return get_socket(SOCK_DGRAM, IPPROTO_UDP); }
uint32_t get_raw_socket() { return get_socket(SOCK_RAW, IPPROTO_RAW); }