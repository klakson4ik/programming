#ifndef CURLY_STCT
#define CURLY_STCT

#include "../config.h"
#include <netinet/in.h>

typedef struct {
  char data[PACKET_LEN];
  ssize_t length;
} Data;

typedef struct {
  Data buf;
  struct sockaddr_in addr;
  socklen_t addr_len;
} Stct;

Stct get_udp_struct(const char *ip, const uint16_t port);
Stct get_udp_struct_any(const uint16_t port);
Stct init_struct();

#endif