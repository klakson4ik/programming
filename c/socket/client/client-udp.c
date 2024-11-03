#include "../apps/chat.h"
#include "../libs/socket.h"

int main(void) {

  uint32_t socket = get_udp_socket();
  Stct server = get_udp_struct(SERVER_IP, SERVER_PORT);

  chat(socket, &server);

  return 0;
}