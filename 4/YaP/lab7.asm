text	segment
assume	CS:text,dS:data,es:data
begin: 
	mov	ax,data
	mov	ds,ax
	mov es,ax
print:	
	mov ah,09h
	mov dx,offset mes
	int 21h
read:
	mov ah,01h
	int 21h
	mov n1,al
	
	mov ah,01h
	int 21h
	mov n2,al
	
	mov ah,09h
	mov dx,offset ent
	int 21h

obrab:
	cld
	xor ax,ax
	
	lea di, mes
	mov al,n1
	mov cx,26
c1:
	scasb
	je OK1
loop c1
OK1:
	mov dx,di
	
	mov al,n2
	mov cx,26
	lea di, mes
c2:
	scasb
	je OK2
loop c2
OK2:
	mov bx,di
	
	sub bx,dx
	
	mov cx,bx
	
tratata:
	xor dx,dx
	mov ax,cx
	mov bx,10
	div bx
	
	mov ah,02h
	add ax,30h
	mov dx,ax
	int 21h
	
	xor dx,dx
	mov ax,cx
	div bx
	mov ax,dx
	
	mov ah,02h
	add ax,30h
	mov dx,ax
	int 21h
	
exit:
	mov	ax,4C00h
	int	21h
text	ends
data	segment
;########################
		db	'Begin of Data Segment'
mes		db	'abcdefghijklmnopqrstuvwxyz',10,13,'$'
n1		db 0
n2		db 0
ent		db	10,13,'$'

data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
