text	segment
assume	CS:text,DS:data

begin:
	mov	AX,data
	mov	DS,AX
	
	mov DX,offset mas1
	mov AH,09h
	int 21h
	mov DX,offset mas2
	mov AH,09h
	int 21h
	
	mov	CX,11
	pr1:
		mov BX,CX
		mov AL,mas1[BX-1]
		push AX
	loop pr1
	mov CX,12
	pr2:
		mov BX,CX
		mov AL,mas2[BX-1]
		push AX
	loop pr2
	
	;проверка
	mov CX,20
	prov:
		mov DX,CX
		pop AX
		mov AH,0
		
		mov CX,11
		c1:
			mov BX,CX
			cmp mas1[BX-1],AL
			jz inc1
			ret1:
		loop c1
		
		mov CX,9
		c2:
			mov BX,CX
			cmp mas2[BX-1],AL
			jz inc2
			ret2:
		loop c2
		
		cmp AH,1
		jz print
		ret3:
		
		mov CX,DX
	loop prov
	
	mov	ax,4C00h
	int	21h
	
	inc1:
		inc AH
		jmp ret1
	inc2:
		inc AH
		jmp ret2
	print:
		push DX
		mov DX,AX
		mov AH,02h
		int 21h
		pop DX
		jmp ret3

text	ends
data	segment
	mas1	db 'abcdecdecde',10,13,'$'
	mas2	db 'cdefghfgfg',10,13,'$'
data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
