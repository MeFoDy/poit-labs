text1   segment         
        assume  cs:text1,DS:data
main    proc            
        mov     AX,data 
        mov     DS, AX  
        mov     CX, 10  
cycle:  mov     AX,200  
        call    far ptr delay   
        mov     AH,09h  
        mov     DX,offset string
        int     21h     
        loop    cycle   
        mov     AX,4C00h        
        int     21h     
main    endp            
text1   ends            
text2   segment         
        assume  cs:text2        
delay   proc far                
        push    CX      
        mov     CX, AX  
        outer:  push    CX
        mov     CX,65535
inner:  loop    inner
        pop     CX
        loop    outer
        pop     CX
        ret     
delay   endp    
text2   ends    
data    segment 
string  db '<> $'       
data    ends    
stk     segment stack   
        db      256 dup(0)
stk     ends    
        end     main
