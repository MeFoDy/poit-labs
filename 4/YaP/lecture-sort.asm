text	segment
assume	CS:text,DS:data

sort proc
vlozh:
		mov bx,cx
		dec bx
		pop dx
		add bx,dx
		push dx
		add bx,bx
		mov ax,mas[bx+2]
		mov dx,mas[bx]
		cmp ax,dx
		jb next
		mov mas[bx+2],dx
		mov mas[bx],ax
	next:
		loop vlozh
ret
endp

begin:		

	mov	AX,data
	mov	DS,AX

	mov cx,10
	mov dx,0
tratata:
	inc cx
	push cx
	dec cx
	push dx
	call sort
	pop dx
	pop cx
	dec cx
	inc dx
	loop tratata
	
done:	
	mov ax,4C00h
	int 21h

text	ends
data	segment
		db 'Begin of Data Segment'
	mas	dw 0015h, 0012h, 0025h, 0017h, 0010h, 004h, 0001h, 0012h, 0014h, 0013h, 0011h
data	ends
stk		segment stack
	dw 256 dup(0)
stk ends

end begin
