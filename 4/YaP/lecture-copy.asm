text	segment
assume	CS:text,DS:data

copy proc
c1:
	mov ah,[bx]
	mov [di],ah
	inc di
	dec bx
	loop c1
ret
endp

begin: 
	mov	ax,data
	mov	ds,ax

	mov ah,09h
	mov dx,offset str1
	int 21h
	
obrab:
	mov bx,dx
	mov cx,7
	add bx,6
	mov di,offset str2
	
	call copy
	
	mov ah,09h
	mov dx,offset str2
	int 21h
exit:
	mov	ax,4C00h
	int	21h
	
text	ends
data	segment
;########################
		db	'Begin of Data Segment'
str1	db	'ABCDEFG'
		db 	10,13,'$'
str2	db	20 dup(32)
		db	10,13,'$'

data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
