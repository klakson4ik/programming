#include <stdint.h>
struct udphdr *udph_builder(char datagram[], const uint32_t saddr,
                            const uint32_t daddr);
uint16_t get_udph_len(char data[]);