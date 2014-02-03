text	segment
assume	CS:text,DS:data

palindr proc
c1:
	mov ah,[bx]
	mov al,[bx+di]
	cmp al,ah
	jne notpal
	add bx,1
	sub di,2
	loop c1
	
	mov ah,09h
	mov dx,offset mes1
	int 21h
done:
	ret
	
notpal:
	mov ah,09h
	mov dx,offset mes2
	int 21h
	jmp done
	
endp

begin: 
	mov	ax,data
	mov	ds,ax

obrab1:
	mov ah,09h
	mov dx,offset str1
	int 21h
	
	mov cx,6
	mov bx,offset str1
	mov di,cx
	
	call palindr
	
obrab2:
	mov ah,09h
	mov dx,offset str2
	int 21h
	
	mov cx,6
	mov bx,offset str2
	mov di,cx
	
	call palindr

exit:
	mov	ax,4C00h
	int	21h
	
text	ends
data	segment
;########################
		db	'Begin of Data Segment'
mes1	db	' Palindrom :)',10,13,'$'
mes2	db	' Not palindrom :(',10,13,'$'
str1	db	'OLOLOLO'
		db 	'$'
str2	db	'OLOLOSH'
		db	'$'

data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
