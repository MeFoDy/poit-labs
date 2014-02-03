#include <stdio.h>
//11111111111111111111111111
#define SIZE 100

double AtoF (s)
char s[];
{
     double val, power = 1;
     int i, sign = 1, st = 1, valst = 0;
     
     for (i=0; s[i]==' ' || s[i]=='\n' || s[i]=='\t'; i++) {
         ;
		 }
     if (s[i]=='+' || s[i]=='-')     {
		sign = (s[i++]=='+') ? 1 : -1;}
     for (val = 0; s[i]>='0' && s[i]<='9'; i++){
         val = 10*val + s[i] - '0';}
     if (s[i]=='.')        {
		i++;}else{i--;}
     for (power=1; s[i]>='0' && s[i]<='9'; i++)
     {
         val = 10*val + s[i] - '0';
         power *= 10;
     }
     if (s[i]=='e' || s[i]=='E')     {
         i++;
         if (s[i]=='+' || s[i]=='-')   {          
			st = (s[i++]=='-') ? -1 : 1;}
         for (valst = 0; s[i]>='0' && s[i]<='9'; i++){
             valst = 10*valst + s[i] - '0';}
         for ( ; valst>0; valst--){
             power = (st==1) ? power/10.0 : power*10;}
     }
     
     return (sign * val / power);
}
