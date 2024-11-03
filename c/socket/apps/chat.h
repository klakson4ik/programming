#ifndef CURLY_CHAT
#define CURLY_CHAT

#include "../libs/struct.h"
#include <stdint.h>

typedef enum { SERVER, CLIENT } TYPE;

void chat_recv(const uint32_t socket, Stct *stct);
void chat_send(const uint32_t socket, Stct *stct);
void chat_server(const uint32_t socket, Stct *stct);
void chat_client(const uint32_t socket, Stct *stct);
void chat(const uint32_t socket, Stct *stct);

#endif