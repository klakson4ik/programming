#include "struct.h"
#include <stdio.h>

void send_to(const uint32_t socket, const Stct *stct, uint32_t flags) {
  if (sendto(socket, stct->buf.data, stct->buf.length, 0,
             (struct sockaddr *)&stct->addr, stct->addr_len) < 0) {
    perror("sendto failed");
  }
}

void recv_from(const uint32_t socket, Stct *stct, uint32_t flags) {
  stct->buf.length = recvfrom(socket, stct->buf.data, PACKET_LEN, flags,
                              (struct sockaddr *)&stct->addr, &stct->addr_len);
}