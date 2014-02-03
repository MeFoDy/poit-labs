text	segment
assume	CS:text,dS:data,es:data

proc1 proc near
	mov ah,02h
	mov dx,ax
	int 21h
	ret
endp

proc2 proc far
	mov al,chsl1
	add al,30h
	mov ah,02h
	mov dx,ax
	int 21h
	mov al,chsl2
	add al,30h
	mov ah,02h
	mov dx,ax
	int 21h
	ret far
endp

begin: 
	mov	ax,data
	mov	ds,ax
	
	xor ax,ax
	
	mov cx,5
	mov al,c1
cc1:
	call proc1
	inc al
loop cc1

	mov ah,09h
	mov dx,offset ent
	int 21h
	
	mov bh,5
	mov chsl1,bh
	add bh,4
	mov chsl2,bh
	call proc2
	
	xor dx,dx
	mov ah,09h
	mov dx,offset ent
	int 21h
	
	push bp
	mov dx, offset mes3
	push dx
	mov dx, offset mes2
	push dx
	mov dx, offset mes1
	push dx
	call proc3
	pop bp
	
exit:
	mov	ax,4C00h
	int	21h
	
proc3 proc near
	pop cx
	
	mov bp,sp
	
	mov ah,09h
	mov dx,[bp]
	int 21h
	mov dx,[bp+2]
	int 21h
	mov dx,[bp+4]
	int 21h
	push cx
	ret near
endp

text	ends
data	segment
;########################
	db	'Begin of Data Segment'
c1	db	'a'
ent db	10,13,'$'
chsl1 db	'?'
chsl2 db	'?'

mes1 db 'MESSAGE1',10,13,'$'
mes2 db 'message2',10,13,'$'
mes3 db 'MesSAge3',10,13,'$'

data	ends
stk		segment stack
	dw 256 dup(0)
stk ends

end begin
