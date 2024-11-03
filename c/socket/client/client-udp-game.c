#include "../libs/forwarding.h"
#include "../libs/socket.h"
#include <stdio.h>
#include <string.h>

int main(void) {

  uint32_t socket = get_udp_socket();
  Stct server = get_udp_struct(SERVER_IP, SERVER_PORT);
  strcpy(server.buf.data,
         "10&&500493&&CXAPIBSQDMFLNNJIWMOOGGYY_QKAEIHWXZEJGUWJXVQGMKYJR&&468"
         "&&PLAYER_STATE&&CurrencyChange&&soft;350000;");
  server.buf.length = strlen(server.buf.data);
  // printf("STRING: %s\n", server.buf.data);
  send_to(socket, &server, 0);

  return 0;
}