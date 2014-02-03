text segment
assume cs:text, ds:data
begin:
	mov ax,data
	mov ds,ax

	mov ah,3Ch
	mov cx,0
	mov dx,offset fname
	int 21h
	mov handle,ax
write:
	call hexin
	cmp al,27 ; Esc?
	je close
	; Так как в регистре значения хранятся не совсем в человеческом виде, необходимо поменять bh и bl местами
				xchg bh,bl
	mov buf,bx
	mov ah,40h
	mov bx,handle
	mov cx,2
	mov dx,offset buf
	int 21h
	jmp write
close:
	mov ah,09h
	mov dx,offset mesg
	int 21h
	mov ax,4C00h
	int 21h

hexin proc
	mov bx,0
inpt: mov ah,08h
	int 21h
	cmp al,13 ; Enter?
	je done 
	cmp al,27 ; Esc?
	je done1
	cmp al,'0' ; <0?
	jb inpt
	cmp al,'9' ; <=9?
	jbe ok
	cmp al,'F' ; >F?
	ja inpt
	cmp al,'A' ; <A?
	jb inpt
ok:	mov ah,02h
	mov dl,al
	int 21h
	cmp al,'9' ; цифра?
	ja letter
	sub al,'0'
	and ax,0Fh
	jmp addd
letter: sub al,55
	and ax,0Fh
addd: mov cl,4
	sal bx,cl
	or bx,ax
	jmp inpt
done: mov ah,02h
	mov dl,' '
	int 21h
done1: ret
hexin endp

text ends
data segment 
	fname	db	'nums.dat',0
	handle	dw	0
	buf 	dw	0
	mesg	db	10,13,'Mission complete!$'
data ends
stk segment stack
	db 256 dup(0)
stk ends
end begin