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
	
	mov ah,09h
	mov dx,offset ent
	int 21h
	
	mov ah,09h
	mov dx,offset s
	int 21h
	
	mov ah,09h
	mov dx,offset ent
	int 21h

obrab:
	cld
	xor ax,ax
	
	mov cx, l_mes
	lea di, mes
	
	mov al, s
	
search:
	push cx
	push di

	lea si, s
	repne scasb
	
	mov bx, cx
	dec di
	mov cx, l_s
	repe cmpsb
	je tratata
	
	pop di
	pop cx
	inc di
loop search
jcxz n_f
	
exit:
	mov	ax,4C00h
	int	21h

n_f:
	mov ah,09h
	mov dx,offset nf
	int 21h
	jmp exit
	
tratata:	
mov cx, bx
mov bx, l_mes
cc:
	dec bx
loop cc

	mov cx, bx
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
jmp exit	

text	ends
data	segment
;########################
		db	'Begin of Data Segment'
mes		db	'abcdefghijklmnopqrstuvwxyz$'
l_mes = $ - mes - 1
s		db	'abcc$'
l_s = $ - s - 1
nf	db	'NOT FOUND$'
ent db 10,13,'$'

data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
