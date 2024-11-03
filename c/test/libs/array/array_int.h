#include <stdio.h>

void array_copy_s(int *const dst, const int *const src, const size_t len);
int *array_merge_s(const int array1[], const int array2[], const size_t length1, const size_t length2);
void array_insert_s(int arr[], const size_t len, const int el, const size_t pos);
void array_show(const int arr[] , const size_t len);
int array_in_s(const int arr[] , const size_t len, const int el);
int array_index_s(const int arr[] , const size_t len, const int el);