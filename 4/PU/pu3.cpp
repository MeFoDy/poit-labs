// pu3.cpp: определяет точку входа для консольного приложения.
//
#pragma inline
#include "stdafx.h"
#include <stdio.h>
#include <stdlib.h>
#include "pci_c_header.h"
#include <Windows.h>

int adr=0, res=0;

int main()
{
	int i,j,l, q;
	int vendor_id, device_id, class_code;
	//system("net start giveio");
	HANDLE h=CreateFile(L"\\\\.\\giveio" , GENERIC_READ, 0, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	if (h == INVALID_HANDLE_VALUE)
    {
       printf("Couldn't access GIVEIO driver\n");
       printf("GIVEIO driver must be loaded first\n");
	   getchar();
       return -1;
    }

	for (i=0; i<(1<<8); i++) {
		for (j=0; j<(1<<5); j++) {
				
				l=1;
				adr = (1<<31) | (i<<16) | (j<<11) | l;

				_asm {
					mov dx,0x0CF8
					mov EAX, adr
					out dx,EAX
					mov dx,0CFCh
					in eax,dx
					mov res,eax
				}

				device_id = (res>>16) & 0xFFFF;
				vendor_id = res & 0xFFFF;
				if (device_id == 0xFFFF) continue;

				adr = adr | 0x08;
				res = 0;

				_asm {
					mov dx,0x0CF8
					mov EAX, adr
					out dx,EAX
					mov dx,0CFCh
					in eax,dx
					mov res,eax
				}
				class_code = (res>>8) & 0xFFFFFF;  
				printf("%X:%X:%X\n",(class_code>>16)&0xFF,(class_code>>8)&0xFF,class_code & 0xFF);

				for (q=0; q<PCI_VENTABLE_LEN; q++) {
					if (PciVenTable[q].VenId == vendor_id) {
						printf("Vendor ID: %s\n",PciVenTable[q].VenFull);
						q++;
						break;
					}
				}
				for (q=0; q<PCI_DEVTABLE_LEN; q++) {
					if (PciDevTable[q].DevId == device_id && PciDevTable[q].VenId == vendor_id) {
						printf("Device ID: %s\n",PciDevTable[q].ChipDesc);
						q--;
						break;
					}
				}
				if (q==PCI_DEVTABLE_LEN) printf("Device ID: 0x%X\n",device_id);

				adr = (1<<31) | (i<<16) | (j<<11) | l;
				adr = adr | 0x0C;

				_asm {
					mov dx,0x0CF8
					mov EAX, adr
					out dx,EAX
					mov dx,0CFCh
					in eax,dx
					mov res,eax
				}

				int header_type = (res>>16) & 0xF;
				if (!header_type) {
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x10;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					int bar = res & 0xFFFFFFFF;
					printf("BAR_0: %X\n",bar);
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x14;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					bar = res & 0xFFFFFFFF;
					printf("BAR_1: %X\n",bar);
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x18;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					bar = res & 0xFFFFFFFF;
					printf("BAR_2: %X\n",bar);
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x1C;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					bar = res & 0xFFFFFFFF;
					printf("BAR_3: %X\n",bar);
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x20;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					bar = res & 0xFFFFFFFF;
					printf("BAR_4: %X\n",bar);
					adr = (1<<31) | (i<<16) | (j<<11) | l;
					adr = adr | 0x24;

					_asm {
						mov dx,0x0CF8
						mov EAX, adr
						out dx,EAX
						mov dx,0CFCh
						in eax,dx
						mov res,eax
					}

					bar = res & 0xFFFFFFFF;
					printf("BAR_5: %X\n",bar);
				}
				printf("_______________\n");
		}
	}
	
	
	getchar();
	return 0;
}

