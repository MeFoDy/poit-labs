// Lab1.cpp : main project file.

#include "stdafx.h"

using namespace std;

int _tmain(int argc, _TCHAR* argv[])
{
	if (argc != 5) {
		cout << "Usage: " << argv[0] << " <source_file> <destination_file> <algorythm> <key_path>";
	}
	else {
		// set crypt algorythm and its params
		DWORD ENCRYPT_ALGORITHM;
		DWORD ENCRYPT_BLOCK_SIZE;
		DWORD KEYLENGTH;
		if (_tcscmp(argv[3], TEXT("CALG_RC2")) == 0) {
			ENCRYPT_ALGORITHM = CALG_RC2;
			ENCRYPT_BLOCK_SIZE = 64;
			KEYLENGTH = 40;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_RC4")) == 0) {
			ENCRYPT_ALGORITHM = CALG_RC4;
			ENCRYPT_BLOCK_SIZE = 64;
			KEYLENGTH = 40;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_DES")) == 0) {
			ENCRYPT_ALGORITHM = CALG_DES;
			ENCRYPT_BLOCK_SIZE = 64;
			KEYLENGTH = 56;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_3DES_112")) == 0) {
			ENCRYPT_ALGORITHM = CALG_3DES_112;
			ENCRYPT_BLOCK_SIZE = 64;
			KEYLENGTH = 112;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_3DES")) == 0) {
			ENCRYPT_ALGORITHM = CALG_3DES;
			ENCRYPT_BLOCK_SIZE = 64;
			KEYLENGTH = 168;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_AES_128")) == 0) {
			ENCRYPT_ALGORITHM = CALG_AES_128;
			ENCRYPT_BLOCK_SIZE = 128;
			KEYLENGTH = 128;
		}
		else if (_tcscmp(argv[3], TEXT("CALG_AES_192")) == 0) {
			ENCRYPT_ALGORITHM = CALG_AES_192;
			ENCRYPT_BLOCK_SIZE = 128;
			KEYLENGTH = 192;
		}
		else {
			ENCRYPT_ALGORITHM = CALG_AES_256;
			ENCRYPT_BLOCK_SIZE = 128;
			KEYLENGTH = 256;
		}

		// open file descriptors
		HANDLE hSource;
		LPTSTR pszSource = argv[1];
		hSource = CreateFile(pszSource, FILE_READ_DATA, FILE_SHARE_READ, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
		if (INVALID_HANDLE_VALUE != hSource)
		{
			cout << "Could not open source file\n" << argv[1];
			return 0;
		}
		FILE * hDestination = fopen(argv[2], "w");
		if (hDestination == NULL) {
			cout << "Could not create destination file\n" << argv[2];
			return 0;
		}

		HANDLE hDestination;
		LPTSTR pszDestination = argv[2];
		hSource = CreateFile(pszDestination, FILE_READ_DATA, FILE_SHARE_READ, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
		if (INVALID_HANDLE_VALUE != hDestination)
		{
			cout << "Could not open source file\n" << argv[1];
			return 0;
		}

		FILE * keyDestionation = fopen(argv[4], "w");
		if (keyDestionation == NULL) {
			cout << "Could not create key file\n" << argv[4];
			return 0;
		}

		// generate key
		HCRYPTPROV hProv;
		HCRYPTKEY hKey, hPublicKey, hNewKey, hXchgKey;
		DWORD dwBlobLen;
		BYTE *pbKeyBlob;
		LPCTSTR pszContainerName = TEXT("My Key Container");
		BOOL AllRight = false;
		if (CryptAcquireContext(&hProv, pszContainerName, NULL, PROV_RSA_FULL, 0))
		{
			AllRight = true;
		}
		else
		{
			if (GetLastError() == NTE_BAD_KEYSET)
			{
				if (CryptAcquireContext(&hProv, pszContainerName, NULL, PROV_RSA_FULL, CRYPT_NEWKEYSET))
				{
					AllRight = true;
				}
			}
		}
		if (!AllRight) {
			std::cout << "Could not create key container" << std::endl;
			return 0;
		}

		AllRight = false;
		if (CryptGetUserKey(hProv, AT_KEYEXCHANGE, &hXchgKey))
		{
			AllRight = true;
		}
		else
		{
			if (GetLastError() == NTE_NO_KEY)
			{
				if (CryptGenKey(hProv, AT_KEYEXCHANGE, 0, &hXchgKey))
				{
					AllRight = true;
				}
			}
		}
		if (!AllRight) {
			std::cout << "Could not get user key" << std::endl;
			return 0;
		}

		AllRight = false;
		if (CryptGenKey(hProv, ENCRYPT_ALGORITHM, CRYPT_EXPORTABLE, &hKey))
		{
			if (CryptExportKey(hKey, hXchgKey, SIMPLEBLOB, 0, NULL, &dwBlobLen))
			{
				if (pbKeyBlob = (BYTE*)malloc(dwBlobLen))
				{
					if (CryptExportKey(hKey, hXchgKey, SIMPLEBLOB, 0, pbKeyBlob, &dwBlobLen))
					{
						printf("Contents have been written to the BLOB. \n");
						fwrite(pbKeyBlob, 1, dwBlobLen, keyDestionation);
						fclose(keyDestionation);
						AllRight = true;
					}
					else
					{
						AllRight = false;
					}
				}
				else
				{
					AllRight = false;
				}
			}
			else
			{
				AllRight = false;
			}
		}
		else
		{
			AllRight = false;
		}
		if (!AllRight) {
			std::cout << "Could not export key" << std::endl;
			return 0;
		}

		// chipher data
		DWORD dwBlockLen = 1000 - 1000 % ENCRYPT_BLOCK_SIZE;
		DWORD dwBufferLen, dwCount;
		if (ENCRYPT_BLOCK_SIZE > 1)
		{
			dwBufferLen = dwBlockLen + ENCRYPT_BLOCK_SIZE;
		}
		else
		{
			dwBufferLen = dwBlockLen;
		}

		BYTE * pbBuffer;
		if (pbBuffer = (BYTE *)malloc(dwBufferLen))
		{
			
		}
		else
		{
			return 0;
		}

		bool fEOF = FALSE;
		do
		{
			if (!ReadFile(hSource, pbBuffer, dwBlockLen, &dwCount, NULL))
			{
				return 0;
			}
			if (dwCount < dwBlockLen)
			{
				fEOF = TRUE;
			}

			if (!CryptEncrypt(hKey, NULL, fEOF, 0, pbBuffer, &dwCount, dwBufferLen))
			{
				return 0;
			}

			if (!WriteFile(hDestination, pbBuffer, dwCount, &dwCount, NULL))
			{
				return 0;
			}
		} while (!fEOF);


		// Free memory
		free(pbKeyBlob);

		if (hKey)
			CryptDestroyKey(hKey);

		if (hXchgKey)
			CryptDestroyKey(hXchgKey);

		if (hProv)
			CryptReleaseContext(hProv, 0);
		printf("The program ran to completion without error. \n");
	}
}
