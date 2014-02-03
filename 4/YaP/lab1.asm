name prog

.model small

.data
;########################
	db	'Begin of Data Segment'
	
x1	db	?,?
	db	1,2,3
x3	dw	2040h
	dw	?
x5	dd	?,?
x6	dq	1122334455667788h
	dt	0AABBCCDDEEFF11223344h
str1	db	'Stroka1','Slovo2'
symb	db	'H'
mes		db	'Begin',10,13,'$'

x	dw	15
y	dw	13
	
.code
;########################
main	proc	far
start:
	mov	ax,@data
	mov	ds,ax
print:	
	mov ah,09h
	mov dx,offset mes
	int 21h
read:
	mov ah,01h
	int 21h
	mov bl,al
	sub bl,30h
	mov al,bl
	mov dx,10
	mul dx
	mov bl,al
	mov bh,bl
	
	mov ah,01h
	int 21h
	mov bl,al
	sub bl,30h
	add bh,bl
	mov cx,bx
	mov cl,ch
	xor ch,ch
	
	mov ax,' '
	mov ah,02h
	mov dx,ax
	int 21h
	
	mov ah,01h
	int 21h
	mov bl,al
	sub bl,30h
	mov al,bl
	mov dx,10
	mul dx
	mov bl,al
	mov bh,bl
	
	mov ah,01h
	int 21h
	mov bl,al
	sub bl,30h
	add bh,bl
	mov bl,bh
	xor bh,bh
	add cx,bx
	
	mov ax,' '
	mov ah,02h
	mov dx,ax
	int 21h
adding:	
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
	
main	endp
;#######################
end	start
