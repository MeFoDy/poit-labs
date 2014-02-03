// lab1.cpp : Defines the entry point for the console application.
//

#include "stdafx.h"
#pragma comment(lib, "Netapi32.lib")
#pragma comment(lib, "mpr.lib")

#include <windows.h>
#include <stdio.h>
#include <winnetwk.h>
#include <conio.h>


typedef struct _ASTAT_
{
	ADAPTER_STATUS adapt;
	NAME_BUFFER    NameBuff [30];
}ASTAT, * PASTAT;

ASTAT Adapter;

// Функция получения MAC адреса.
// На вход получает указатель на буфер, куда записывается строковое
// представление полученного MAC адреса.
BOOL GetMacAddress(char *buffer)
{
	NCB ncb;
	UCHAR uRetCode;
	char NetName[255];

	memset( &ncb, 0, sizeof(ncb) );
	ncb.ncb_command = NCBRESET;
	ncb.ncb_lana_num = 0;

	uRetCode = Netbios( &ncb );

	memset( &ncb, 0, sizeof(ncb) );
	ncb.ncb_command = NCBASTAT;
	ncb.ncb_lana_num = 0;

	strcpy( (char *) ncb.ncb_callname, /*sizeof(ncb.ncb_callname),*/  "*               " );
	ncb.ncb_buffer = (unsigned char *) &Adapter;
	ncb.ncb_length = sizeof(Adapter);

	uRetCode = Netbios( &ncb );
	if ( uRetCode == 0 )
	{
		sprintf(buffer, "%02X-%02X-%02X-%02X-%02X-%02X\n",
			Adapter.adapt.adapter_address[0],
			Adapter.adapt.adapter_address[1],
			Adapter.adapt.adapter_address[2],
			Adapter.adapt.adapter_address[3],
			Adapter.adapt.adapter_address[4],
			Adapter.adapt.adapter_address[5] );
		return TRUE;
	}
	return FALSE;
}


// ===============================================



void DisplayStruct(int i, LPNETRESOURCE lpnrLocal)
{
	printf("Type of %d resourse: ", i);
	switch (lpnrLocal->dwDisplayType) {
	case (RESOURCEDISPLAYTYPE_GENERIC):
		printf("generic\n");
		break;
	case (RESOURCEDISPLAYTYPE_DOMAIN):
		printf("domain\n");
		break;
	case (RESOURCEDISPLAYTYPE_SERVER):
		printf("server\n");
		break;
	case (RESOURCEDISPLAYTYPE_SHARE):
		printf("share\n");
		break;
	case (RESOURCEDISPLAYTYPE_FILE):
		printf("file\n");
		break;
	case (RESOURCEDISPLAYTYPE_GROUP):
		printf("group\n");
		break;
	case (RESOURCEDISPLAYTYPE_NETWORK):
		printf("network\n");
		break;
	default:
		printf("неизвестный тип %d\n", lpnrLocal->dwDisplayType);
		break;
	}

	printf("Remotename of %d resourse: %S\n", i, lpnrLocal->lpRemoteName);
	printf("\n");
}




BOOL WINAPI EnumerateFunc(LPNETRESOURCE lpnr)
{
	DWORD dwResult, dwResultEnum;
	HANDLE hEnum;
	DWORD cbBuffer = 16384;     // 16kb
	DWORD cEntries = -1;        // все возможные
	LPNETRESOURCE lpnrLocal;    
	DWORD i;
	//
	// Вызов функции WNetOpenEnum для начала перечисления компьютеров.
	//
	dwResult = WNetOpenEnum(RESOURCE_GLOBALNET, // все сетевые ресурсы
		RESOURCETYPE_ANY,   // все ресурсы
		0,  // перечислить все ресурсы
		lpnr,       // NULL при первом вызове функции
		&hEnum);    // дескриптор ресурса

	if (dwResult != NO_ERROR) {
		printf("WnetOpenEnum failed with error %d\n", dwResult);
		return FALSE;
	}
	//
	// Вызвов функции GlobalAlloc для выделения ресурсов.
	//
	lpnrLocal = (LPNETRESOURCE) GlobalAlloc(GPTR, cbBuffer);
	if (lpnrLocal == NULL) {
		printf("WnetOpenEnum failed with error %d\n", dwResult);
		//      NetErrorHandler(hwnd, dwResult, (LPSTR)"WNetOpenEnum");
		return FALSE;
	}

	do {
		// Инициализируем буфер.
		ZeroMemory(lpnrLocal, cbBuffer);
		// Вызов функции WNetEnumResource для продолжения перечисления
		// доступных ресурсов сети.
		dwResultEnum = WNetEnumResource(hEnum,  // resource handle
			&cEntries,      // defined locally as -1
			lpnrLocal,      // LPNETRESOURCE
			&cbBuffer);     // buffer size
		// Если вызов был успешен, то структуры обрабатываются циклом.
		if (dwResultEnum == NO_ERROR) {
			for (i = 0; i < cEntries; i++) {

				DisplayStruct(i, &lpnrLocal[i]);
				//  Если структура NETRESOURCE является контейнером, то
				//  функци\ EnumerateFunc вызывается рекурсивно.

				if (RESOURCEUSAGE_CONTAINER == (lpnrLocal[i].dwUsage
					& RESOURCEUSAGE_CONTAINER))
					if (!EnumerateFunc(&lpnrLocal[i]))
						printf("EnumerateFunc returned FALSE\n");
				//            TextOut(hdc, 10, 10, "EnumerateFunc returned FALSE.", 29);
			}
		}
		else if (dwResultEnum != ERROR_NO_MORE_ITEMS) {
			printf("WNetEnumResource failed with error %d\n", dwResultEnum);

			//      NetErrorHandler(hwnd, dwResultEnum, (LPSTR)"WNetEnumResource");
			break;
		}
	}
	while (dwResultEnum != ERROR_NO_MORE_ITEMS);
	GlobalFree((HGLOBAL) lpnrLocal);
	// Вызов WNetCloseEnum для остановки перечисления.
	dwResult = WNetCloseEnum(hEnum);

	if (dwResult != NO_ERROR) {
		printf("WNetCloseEnum failed with error %d\n", dwResult);
		//    NetErrorHandler(hwnd, dwResult, (LPSTR)"WNetCloseEnum");
		return FALSE;
	}

	return TRUE;
}


//====================================================


char buffer[1000];
int _tmain(int argc, _TCHAR* argv[])
{

	if (GetMacAddress(buffer)) {
		printf("Mac: %s\n",buffer);
	}
	else {
		printf("Mac cannot be displayed\n");
	}

	LPNETRESOURCE lpnr = NULL;

    if (EnumerateFunc(lpnr) == FALSE) {
        printf("Call to EnumerateFunc failed\n");
    } 

	_getch();
	return 0;
}

