#ifdef DEV
#define DEBUG
#include <assert.h>
#include <string.h>
#include <errno.h>
#define assertf(x, msg)       \
    {                         \
        fprintf(stderr, msg, ...); \
        putchar('\n');        \
        if (errno != 0)       \
        {                     \
            strerror(errno);  \
            putchar('\n');    \
        }                     \
        assert(x);            \
    }
#else
#endif