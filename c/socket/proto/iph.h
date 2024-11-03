#include <stdint.h>
struct iphdr *iph_builder(char datagram[], const uint32_t ihl,
                          const uint32_t version, const uint8_t tos,
                          const uint16_t id, const uint16_t frag_off,
                          const uint8_t ttl, const uint8_t protocol,
                          const uint32_t saddr, const uint32_t daddr);

uint16_t get_iph_len(char data[]);