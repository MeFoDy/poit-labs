text	segment
assume	CS:text,DS:data

begin:
	mov	AX,data
	mov	DS,AX
	
	xor ax,ax
	
prov:
	mov ah,08h
	int 21h
	
	cmp al,48
	je Pnol
	cmp al,49
	je Podin
	cmp al,50
	je Pdva
	cmp al,51
	je Ptri
	cmp al,52
	je Pchet
	cmp al,53
	je Ppat
	cmp al,54
	je Pshest
	cmp al,55
	je Psem
	cmp al,56
	je Pvosem
	cmp al,57
	je Pdevat
	cmp al,13
	je Penter
	cmp al,27
	je done
	mov dl,al
	mov ah,02h
	int 21h
	next:
	jmp prov
done:	
	mov ax,4C00h
	int 21h
	
Pnol:
	mov dx,offset nol
	mov ah,09h
	int 21h
	jmp next
Podin:
	mov dx,offset odin
	mov ah,09h
	int 21h
	jmp next
Pdva:
	mov dx,offset dva
	mov ah,09h
	int 21h
	jmp next
Ptri:
	mov dx,offset tri
	mov ah,09h
	int 21h
	jmp next
Pchet:
	mov dx,offset chet
	mov ah,09h
	int 21h
	jmp next
Ppat:
	mov dx,offset pat
	mov ah,09h
	int 21h
	jmp next
Pshest:
	mov dx,offset shest
	mov ah,09h
	int 21h
	jmp next
Psem:
	mov dx,offset sem
	mov ah,09h
	int 21h
	jmp next
Pvosem:
	mov dx,offset vosem
	mov ah,09h
	int 21h
	jmp next
Pdevat:
	mov dx,offset devat
	mov ah,09h
	int 21h
	jmp next
Penter:
	mov dx,offset ent
	mov ah,09h
	int 21h
	jmp next

text	ends
data	segment
	odin db 'one$'
	dva db 'two$'
	tri db 'three$'
	chet db 'four$'
	pat db 'five$'
	shest db 'six$'
	sem db 'seven$'
	vosem db 'eight$'
	devat db 'nine$'
	nol db 'zero$'
	ent db 10,13,'$'
data	ends
stk		segment stack
	db 256 dup(0)
stk ends

end begin
