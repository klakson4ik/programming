#include "struct.h"
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

Stct get_udp_base_struct(const uint16_t port) {
  Stct stct = init_struct();
  stct.addr.sin_port = htons(port);
  stct.addr.sin_family = AF_INET;
  return stct;
}
Stct get_udp_struct(const char *ip, const uint16_t port) {
  Stct stct = get_udp_base_struct(port);
  if (inet_pton(AF_INET, ip, &stct.addr.sin_addr) <= 0) {
    perror("Error in DESTINATION IP translation to special numeric format");
    exit(EXIT_FAILURE);
  }
  return stct;
}

Stct get_udp_struct_any(const uint16_t port) {
  Stct stct = get_udp_base_struct(port);
  stct.addr.sin_addr.s_addr = INADDR_ANY;
  return stct;
}

Stct init_struct() {
  Stct stct;
  memset(&stct.buf.data, '\0', sizeof(stct.buf.data));
  memset(&stct, '\0', sizeof(stct));
  stct.addr_len = sizeof(stct.addr);
  stct.buf.length = 0;
  return stct;
}