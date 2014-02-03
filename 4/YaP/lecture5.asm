; Студент - Дубко Никита Александрович, группа 051002
; Задание: добавить поддержку клавишы Backspace при вводе десятичных чисел
.386
text segment use16
assume cs:text, ds:data
begin:
	mov ax,data
	mov ds,ax
	
	mov ah,02h
	mov dl,'>'
	int 21h
	mov di,0
inpt:	mov ah,08h
	int 21h
	cmp al,13
	je done
	cmp al,8h ; проверка на Backspace
	je back
	cmp al,'9'
	ja inpt
	cmp AL,'0'
	jb inpt
	mov ah,02h
	mov dl,al
	int 21h
	sub al,'0'
	xor ah,ah
	mov cx,ax
	mov ax,di
	mov bx,10
	mul bx
	add ax,cx
	mov di,ax
	jmp inpt
; вызов процедуры обработки Backspace	
back: call back_asc
	jmp inpt	
done: mov ax,di
	mov si,offset result+3
	call wrd_asc
	mov ah,09h
	mov dx,offset result
	int 21h
	mov ax,4C00h
	int 21h
wrd_asc proc
	pusha
	mov bx,0f000h
	mov dl,12
	mov cx,4
cccc: push cx
	push ax
	and ax,bx
	mov cl,dl
	shr ax,cl
	call bin_asc
	mov byte ptr[si],al
	inc si
	pop ax
	shr bx,4
	sub dl,4
	pop cx
	loop cccc
	popa
	ret
wrd_asc endp
bin_asc proc
	cmp al,9
	ja lettr
	add al,30h
	jmp ok
lettr: add al,37h
ok: ret
bin_asc endp
; процедура обработки Backspace сигнала
back_asc proc	
	; Визуальная составляющая
	mov  ah,03h		; определяем текущее положение курсора
	int  10h          
	cmp dl,1 		; если левее уже некуда
	je not_back 	; не переводим курсор влево
	mov  ah,02h		; перемещаем его назад на одну позицию
	dec  dl            
	int  10h
	push dx			; сохраняем эту позицию
	mov  ah,02h		; стираем предыдущий символ
	mov  dl,' '
	int  21h
	pop  dx 		; возвращаем позицию
	mov  ah,02h		; возвращаем курсор
	int  10h
	; Логическая составляющая
	mov ax,di
	mov dx,0
	mov bx,10
	div bx
	mov di,ax
not_back: ret
back_asc endp
text ends
data segment use16
	result db ' = ', 5 dup (?),'$'
data ends
stk segment stack
	db 256 dup(0)
stk ends
end begin