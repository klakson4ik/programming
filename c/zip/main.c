#include <malloc.h>
#include "stdio.h"
#include "string.h"
#include "libs/clock.h"

void repeatSymbolsSave(char arrChar[], int *countRepeat, int *count);

void repeatSymbols(char arrChar[], char ch, int *countRepeat, int *count);

int main(int argc, char const *argv[]) {
    double startTime, endTime;
    startTime = getCPUTime();

    char blockChar[64];
    int count = 0;
    int oldCount = 0;
    char arrChar[65448];
    FILE *fp = fopen("text.txt", "r");
    if (fp) {
        while ((fgets(blockChar, 64, fp)) != NULL) {
            int length;
            length = strlen(blockChar) - 1;
            int countRepeat = 0;
            for (size_t i = 0; i < length; ++i) {
//                printf("%d", blockChar[i]);
                ++oldCount;
                repeatSymbols(arrChar, blockChar[i], &countRepeat, &count);

            }
        }
        fclose(fp);
    }
//    printf("\n------------------------\n");
//    for (size_t i = 0; i < count; ++i) {
//        printf("%c", arrChar[i]);
//    }
//    printf("\n\r");

    printf("размер итог: %d \n\r", count);
    printf("размер итог-оригинал: %d \n\r", oldCount);


    endTime = getCPUTime( );

    fprintf( stderr, "\nCPU time used = %lf\n", (endTime - startTime) );
    return 0;
}

void repeatSymbols(char arrChar[], char ch, int *countRepeat, int *count) {
    char num1, num2, num3;
    num1 = ch / 100;
    num2 = (ch % 100) / 10;
    num3 = ch % 10;
    printf("%d", num3);
    if (num1 > 0) {
        if (1 == num1) {
            (*countRepeat)++;
        } else {
            repeatSymbolsSave(arrChar, countRepeat, count);
            arrChar[(*count)++] = num1 + '0';
        }
    }
    if (1 == num2) {
        (*countRepeat)++;
    } else {
        repeatSymbolsSave(arrChar, countRepeat, count);
        arrChar[(*count)++] = num2 + '0';
    }
    if (1 == num3) {
        (*countRepeat)++;
    } else {
        repeatSymbolsSave(arrChar, countRepeat, count);
        arrChar[(*count)++] = num3 + '0';
    }
}

void repeatSymbolsSave(char *arrChar, int *countRepeat, int *count) {
    if (*countRepeat > 3) {
        arrChar[(*count)++] = (*countRepeat - 3) + '0';
        arrChar[(*count)++] = '*';
    }
    if (*countRepeat > 0 && *countRepeat <= 2) {
        for (size_t i = 0; i < *countRepeat; ++i) {
            arrChar[(*count)++] = '1';
        }
    }
    *countRepeat = 0;
}

