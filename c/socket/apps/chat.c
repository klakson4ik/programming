#include "chat.h"
#include "../libs/forwarding.h"
#include <fcntl.h>
#include <stdio.h>
#include <string.h>
#include <unistd.h>

void chat_recv(const uint32_t socket, Stct *stct) {
  recv_from(socket, stct, RECV_FLAFS);

  if (stct->buf.length > 0) {
    stct->buf.data[stct->buf.length] = '\0';
    printf("Server : %s\n", stct->buf.data);
    memset(stct->buf.data, '\0', stct->buf.length);
  }
}

void chat_send(const uint32_t socket, Stct *stct) {
  if (read(0, stct->buf.data, PACKET_LEN) > 0) {
    stct->buf.length = strlen(stct->buf.data);
    send_to(socket, stct, SEND_FLAGS);
    memset(stct->buf.data, '\0', stct->buf.length);
  }
}

void chat_server(const uint32_t socket, Stct *stct) {
  while (1) {
    chat_recv(socket, stct);
    chat_send(socket, stct);
    sleep(LOOP_SLEEP);
  }
}

void chat_client(const uint32_t socket, Stct *stct) {
  while (1) {
    chat_send(socket, stct);
    chat_recv(socket, stct);
    sleep(LOOP_SLEEP);
  }
}

void chat(const uint32_t socket, Stct *stct) {
  if (NONBLOCK)
    fcntl(0, F_SETFL, fcntl(0, F_GETFL) | O_NONBLOCK);
  while (1) {
    chat_send(socket, stct);
    chat_recv(socket, stct);
    sleep(LOOP_SLEEP);
  }
}