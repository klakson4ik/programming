#include <netinet/ip.h>
#include <netinet/udp.h>
#include <stdint.h>
#include <string.h>

struct udphdr *udph_builder(char datagram[], const uint32_t saddr,
                            const uint32_t daddr) {
  struct udphdr *udph;
  udph = (struct udphdr *)(datagram + sizeof(struct iphdr));
  udph->source = saddr;
  udph->dest = daddr;
  return udph;
}

uint16_t get_udph_len(char data[]) {
  return htons(8 + strlen(data)); // tcp header size
}