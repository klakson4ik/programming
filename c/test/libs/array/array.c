#include <string.h>
#include <stdio.h>
#include <stdbool.h>

#define LENGTH const size_t length
#define ELEMENT const TYPE element
#define ARRAY TYPE array[]

typedef int TYPE;

void array_copy_s(TYPE dst[], const TYPE src[], LENGTH)
{
	for (size_t i = 0; i < length; i++)
		dst[i] = src[i];
}

// int *array_merge_s(const TYPE array1[], const TYPE array2[], const size_t length1, const size_t length2)
// {
// 	int *new_array;
// 	array_copy_s(new_array, array1, length1);
// 	for (size_t i = 0; i < length2; i++)
// 		new_array[i + length1] = array2[i];
// 	array_show(new_array, 10);
// 	return new_array;
// }

void array_insert_s(ARRAY, LENGTH, ELEMENT, const size_t pos)
{
	TYPE new_arr[length];
	assertf((pos != length - 1), "Позиция %lu указаывает на последний элемент", pos);
	// assert((pos + 1) > length && printf("Доступные позиции 0...%lu\nУказанная позиция: %lu\n", length - 2, pos));
	array_copy_s(new_arr, array, length);
	array[pos] = element;
	for (size_t i = pos + 1; i < length; i++)
		array[i] = new_arr[i - 1];
}

bool array_in_s(ARRAY, LENGTH, ELEMENT)
{
	for (size_t i = 0; i < length; i++)
		if (array[i] == element)
			return true;
	return false;
}

int array_index_s(ARRAY, LENGTH, ELEMENT)
{
	for (size_t i = 0; i < length; i++)
		if (array[i] == element)
			return i;
	return false;
}

void array_show(const ARRAY, LENGTH)
{
	for (size_t i = 0; i < length; i++)
		printf("%d\n", array[i]);
}