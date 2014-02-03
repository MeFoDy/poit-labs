// 9p.cpp: определяет точку входа для консольного приложения.
//

#pragma inline
#include "stdafx.h"
#include  <stdio.h>
#include <stdlib.h>
#include <conio.h>
#include <locale.h>

int main()
{
	setlocale(LC_ALL,"rus");
	int mas[5];
	int i=0;
	char tm[250];
	int vih=0;
	int chi;
	printf("Введите последовательно 5 элементов массива:\n");
	for (i=0;i<5;i++)
	{mas[i]=atoi(gets(tm));}
	printf("Введите элемент - предел:\n");
	chi = atoi(gets(tm));

	_asm{
			mov EAX,chi
			mov ECX,5 
			mov EBX,0
		po:  cmp mas[EBX],EAX
			jle l2
			mov mas[EBX],EAX
			inc vih
		l2:		
			add EBX,4
		loop po 

		}
	
	printf("\n\nВсего замен: %d \n",vih);
	printf("Преобразованный массив: \n");
	for (i=0;i<5;i++) 
		printf("%d \n",mas[i]);
	system("pause");
	return 0;
}

