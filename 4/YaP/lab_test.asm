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
	dt	0AABBCCDDEEFF00112233h
str1	db	'Stroka1','Slovo2'
symb	db	'H'
mas		db	10 dup(0)
mas1	db 	1,2,3,4
mas2	dw	1,2,10
	
.code
;########################
main	proc	far
start:
	mov	ax,@data
	mov	ds,ax
exit:
	mov	ax,4C00h
	int	21h
	
main	endp
;#######################
end	start
