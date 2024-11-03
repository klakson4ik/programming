#include "../apps/chat.h"
#include "../libs/socket.h"

int main(int argc, char const *argv[]) {
  uint32_t socket = get_udp_socket();
  Stct server = get_udp_struct(SERVER_IP, SERVER_PORT);
  Stct client = init_struct();

  bind_socket(socket, server);

  chat(socket, &client);
  return 0;
}
