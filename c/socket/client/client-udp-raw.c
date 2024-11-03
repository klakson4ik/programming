#include "../config.h"
#include "../libs/checksum.h"
#include "../libs/socket.h"
#include "../proto/iph.h"
#include "../proto/udph.h"
#include <arpa/inet.h>
#include <netinet/in.h>
#include <netinet/ip.h>  //Provides declarations for ip header
#include <netinet/udp.h> //Provides declarations for udp header
#include <stdint.h>
#include <stdio.h>  //for printf
#include <string.h> //memset
#include <sys/types.h>

#define PCKT_LEN 1510

int main(void) {
  uint32_t socket = get_raw_socket();

  char *data;
  struct in_addr src_ip, dst_ip;
  uint16_t dst_port, src_port;
  struct sockaddr_in sin;
  struct udphdr *udph;
  struct iphdr *iph;
  ssize_t add_len = sizeof(sin);

  if (inet_pton(AF_INET, SRC_IP, &src_ip) <= 0) {
    perror("Error in SOURCE IP translation to special numeric format");
  }

  if (inet_pton(AF_INET, SERVER_IP, &dst_ip) <= 0) {
    perror("Error in DESTINATION IP translation to special numeric format");
  }

  char datagram[PCKT_LEN] = {0};
  char answer[PCKT_LEN] = {0};
  dst_port = htons(SERVER_PORT);
  src_port = htons(SRC_PORT);

  data = datagram + sizeof(struct iphdr) + sizeof(struct udphdr);

  sin.sin_family = AF_INET;
  sin.sin_port = dst_port;
  sin.sin_addr = dst_ip;

  iph = iph_builder(datagram, 5, 4, 0, 54321, 0, 64, IPPROTO_UDP, src_ip.s_addr,
                    dst_ip.s_addr);
  udph = udph_builder(datagram, src_port, dst_port);

  while (1) {
    memset(data, '\0', strlen(data));
    // memset(answer, '\0', strlen(answer));
    fgets(data, 1400, stdin);
    // strcpy(data, "HELLO FROM CLIENT\n");
    iph->tot_len = get_iph_len(data);
    iph->check = checksum((uint8_t *)datagram, iph->tot_len);
    udph->len = get_udph_len(data); // tcp header size

    // Send the packet
    if (sendto(socket, datagram, iph->tot_len, 0, (struct sockaddr *)&sin,
               add_len) < 0) {
      perror("sendto failed");
    }

    int n = recvfrom(socket, answer, PCKT_LEN, MSG_WAITALL,
                     (struct sockaddr *)&sin, (socklen_t *)&add_len);
    printf("rec N: %d", n);
    answer[n] = '\0';
    printf("Number: %d\n", n);

    printf("Server : %s\n", answer);
  }

  return 0;
}