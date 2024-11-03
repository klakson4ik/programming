#ifdef DEV
#define DEBUG
#include <assert.h>
#include <errno.h>
#include <string.h>
#define assertf(x, msg)                                                        \
  {                                                                            \
    fprintf(stderr, msg, ...);                                                 \
    putchar('\n');                                                             \
    if (errno != 0) {                                                          \
      strerror(errno);                                                         \
      putchar('\n');                                                           \
    }                                                                          \
    assert(x);                                                                 \
  }
#else
#endif