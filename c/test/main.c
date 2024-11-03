#include <stdio.h>
#include "libs/array.h"

int main(void)
{
	int array[10] = { 1, 2, 3};
	array_inert_s(array, 10, 100, 9);		
	return 0;
}