#include <netinet/ip.h>
#include <netinet/udp.h>
#include <stdint.h>
#include <string.h>

struct iphdr *iph_builder(char datagram[], const uint32_t ihl,
                          const uint32_t version, const uint8_t tos,
                          const uint16_t id, const uint16_t frag_off,
                          const uint8_t ttl, const uint8_t protocol,
                          const uint32_t saddr, const uint32_t daddr) {
  struct iphdr *iph;
  iph = (struct iphdr *)datagram;
  iph->ihl = ihl;
  iph->version = version;
  iph->tos = tos;
  iph->id = id; // Id of this packet
  iph->frag_off = frag_off;
  iph->ttl = ttl;
  iph->protocol = protocol;
  iph->check = 0; // Set to 0 before calculating checksum
  iph->saddr = saddr;
  iph->daddr = daddr;
  return iph;
}

uint16_t get_iph_len(char data[]) {
  return sizeof(struct iphdr) + sizeof(struct udphdr) + strlen(data);
}