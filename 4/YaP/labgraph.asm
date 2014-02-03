text	segment
assume	CS:text,DS:data

otris proc

	mov bh,0
	mov cx,x1
c2:
	mov dx,y1
c1:
	int 10h
	inc dx
	cmp dx,y2
	jne c1
	inc cx
	cmp cx,x2
	jne c2
	
	ret

otris endp

begin:		

	mov	AX,data
	mov	DS,AX

	mov ah,0h
	mov al,10h
	int 10h
	
	mov ah,0Ch
	mov al,0Eh
	
	mov x1,100
	mov x2,500
	mov y1,100
	mov y2,300
	call otris
	
	mov ah,0Ch
	mov al,01h
		
	mov x1,175
	mov x2,225
	mov y1,150
	mov y2,200
	call otris
	
	mov ah,0Ch
	mov al,01h
		
	mov x1,375
	mov x2,425
	mov y1,150
	mov y2,200
	call otris
	
	mov ah,0Ch
	mov al,04h
		
	mov x1,175
	mov x2,425
	mov y1,250
	mov y2,270
	call otris
	
	mov ah,0Ch
	mov al,0Eh
		
	mov x1,75
	mov x2,100
	mov y1,130
	mov y2,220
	call otris
	
	mov x1,500
	mov x2,525
	mov y1,130
	mov y2,220
	call otris
	
done:
	mov ah,01h
	int 21h	
	mov ax,4C00h
	int 21h

text	ends
data	segment
		db 'Begin of Data Segment'
	x1	dw 0;
	x2	dw 0;
	y1	dw 0;
	y2	dw 0;
data	ends
stk		segment stack
	db 256 dup(0)
stk ends
end begin
