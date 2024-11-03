#ifndef CURLY_FORWARDING
#define CURLY_FORWARDING
#include "struct.h"

void send_to(const uint32_t socket, const Stct *sctc, uint32_t flags);
void recv_from(const uint32_t socket, Stct *stct, uint32_t flags);
#endif