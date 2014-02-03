text	segment
assume	CS:text,DS:data

begin:
	mov	AX,data
	mov	DS,AX
	
	xor ax,ax
	
prov:
	mov ah,08h
	int 21h
	
	cmp al,27
	je Pesc
	cmp al,9
	je Ptab
	cmp al,32
	je Pspace
	cmp al,85h
	je Pf11
	cmp al,86h
	je Pf12
	cmp al,13
	je done
	next:
	jmp prov
done:	
	mov ax,4C00h
	int 21h
	
	Pesc:
		mov DX,offset escape
		mov AH,09h
		int 21h
		jmp next
	Ptab:
		mov DX,offset tab
		mov AH,09h
		int 21h
		jmp next
	Pspace:
		mov DX,offset space
		mov AH,09h
		int 21h
		jmp next
	Pf11:
		mov DX,offset f11
		mov AH,09h
		int 21h
		jmp next
	Pf12:
		mov DX,offset f12
		mov AH,09h
		int 21h
		jmp next

text	ends
data	segment
	tab	db 'TAB',10,13,'$'
	escape db 'ESC',10,13,'$'
	space db 'SPACE',10,13,'$'
	f11 db 'F11',10,13,'$'
	f12 db 'F12',10,13,'$'
data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
