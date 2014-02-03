 program siaod_2;
uses
        crt;
type
        mas=array [1..6] of byte;
        adr1=^spisok1;
        adr2=^spisok2;
        adr3=^spisok3;
        adr4=^spisok4;
        adr5=^spisok5;
        adr6=^spisok6;
        spisok2=record
          strter:byte;
          next:adr2
        end;
        spisok6=record
          strpodpod:byte;
          next:adr6
        end;
        spisok5=record
          podpod:string[25];
          next:adr5;
          strpodpod:mas;
        end;
        spisok4=record
          strpodter:byte;
          next:adr4
        end;
        spisok3=record
            podter:string[25];
            next:adr3;
            strpodter:mas;
            podpod:adr5
        end;
        spisok1=record
          ter:string[25];
          next:adr1;
          strter:mas;
          podter:adr3
        end;
        mas1=array[1..7] of string[30];
        mas2=array[1..2] of string[30];
        mas3=array[1..3] of string[30];
         mas4=array[1..3] of string[30];
var
        first1:adr1;
        temp1,temp,tempp,temppp,tempppp:adr1;
        temp2:adr2;
        temp3,t,tt,ttt,first3:adr3;
        temp4:adr4;
        temp5,g,gg:adr5;
        temp6:adr6;
        st:string[25];
        n,i,l,k:byte; regim,help:byte;
        kod:char;
        lm:word;
const
        v:array[1..4] of string[35]=('Музыка','Фильмы','Картины','Танец');
        s:array[1..4,1..2] of byte=((3,7),(12,15),(15,17),(23,41));
        p:array[1..4,1..2] of string[35]=(('Классическая','Современная'),('Приключения','Фантастика'),('Пейзажи','Натюрморты'),
        ('Классический','Современный'));
        s2:array[1..4,1..2,1..2] of byte=(((3,9),(18,21)),((19,60),(28,39)),((34,50),(41,51)),((49,50),(53,66)));
        pp:array[1..4,1..2,1..2] of string[35]=((('Классицизм','Романтизм'),('Рок','Поп')),
        (('Индиана Джонс','Австралия'),('Звездные войны','Star Trek')),
                                          (('Мишки в лесу','Утро'),('Девочка с персиками','Ваза')),
                                          (('Жига','Вальс'),('Танго','Стрип-дэнс')));
         s3:array[1..4,1..2,1..2,1..2] of byte=((((4,7),(3,8)),((14,23),(15,16))),(((23,35),(26,75)),((30,54),(12,17))),
         (((15,27),(38,44)),((43,49),(41,49))),(((55,61),(52,80)),((55,57),(59,67))));
        stor1:mas1=('                Просмотр',
                    '               Сортировка',
                    '             Редактирование',
                    '                Удаление',
                    '                Вставка',
                    '                 Поиск',
                    '                 Выход');
        stor2:mas2=('     По алфавиту',
                    '     Постранично');
        stor3:mas3=('       Термин',
                    '     Подтермин',
                    '    Подподтермин');
        stor4:mas4=('     Для термина',
                    '   Для подтермина',
                    '  Для подподтермина');

procedure form;
begin
  clrscr;
  first1:=nil;

  for i:=1 to 4 do
  begin
    if first1=nil then
    begin
      new(temp1);
      first1:=temp1
    end
    else
    begin
      new(temp1^.next);
      temp1:=temp1^.next
    end;
    temp1^.ter:=v[i];
    for n:=1 to 2 do
    temp1^.strter[n]:=s[i,n];
    temp1^.podter:=nil;

    for l:=1 to 2 do
    begin
         if temp1^.podter=nil then

    begin
      new(temp3);
      temp1^.podter:=temp3
    end
    else
    begin
      new(temp3^.next);
      temp3:=temp3^.next
    end;

      temp3^.podter:=p[i,l];
      for n:=1 to 2 do
      temp3^.strpodter[n]:=s2[i,l,n];
         temp3^.podpod:=nil;
      for k:=1 to 2 do
    begin
         if temp3^.podpod=nil then

    begin
      new(temp5);
      temp3^.podpod:=temp5
    end
    else
    begin
      new(temp5^.next);
      temp5:=temp5^.next
    end;

      temp5^.podpod:=pp[i,l,k];
      for n:=1 to 2 do
      temp5^.strpodpod[n]:=s3[i,l,k,n];
      {writeln(temp1^.podtermin.podter) }
      end;
      temp5^.next:=nil;
    end;
   temp3^.next:=nil;
  end;


  temp1^.next:=nil;
  {temp1:=first1;
  while temp1<>nil do
  begin
    writeln(temp1^.ter);
    temp1:=temp1^.next1;
  end;}

end;
procedure print;
begin
  {writeln(temp1^.strtermin.strter)}
  temp1:=first1;
  textcolor(15);
  while temp1<>nil do
  begin
    temp3:=temp1^.podter;
    writeln;
    write('  ',temp1^.ter);
    for i:=wherex to  50 do
      write('─');
    for n:=1 to 6 do
      if temp1^.strter[n]<>0 then
        write(' ',temp1^.strter[n],' ');
    writeln;
    while temp3<>nil do
    begin
      temp5:=temp3^.podpod;writeln;
       write('      ',temp3^.podter);
       for i:=wherex to  50 do
       write('─');
       for n:=1 to 6 do
         if temp3^.strpodter[n]<>0 then
           write(' ',temp3^.strpodter[n],' ');
       writeln;
       writeln;
       while temp5<>nil do
       begin
         write('          ',temp5^.podpod);
         for i:=wherex to  50 do
         write('─');
         for n:=1 to 6 do
           if temp5^.strpodpod[n]<>0 then
             write(' ',temp5^.strpodpod[n],' ');
         writeln;
         temp5:=temp5^.next
       end;
       temp3:=temp3^.next
     end;
     temp1:=temp1^.next;
     Readln;
  end;
end;
procedure sorted;
var
      fl1,fl2,fl3,fl4:boolean;
begin
  temp1:=first1;
   fl1:=true; fl2:=true;
   fl3:=true; fl4:=true;
    while fl1 or fl2 or fl3 do begin
   if temp1^.ter>temp1^.next^.ter then    begin   new(temp);
     temp:=temp1^.next;
     temp1^.next:=temp1^.next^.next;
     temp^.next:=temp1;
     fl1:=true ;
      first1:=temp;
     end
     else fl1:=false;

      if temp1^.ter>temp1^.next^.ter then    begin   new(tempp);
     tempp:=temp1^.next;
     temp1^.next:=temp1^.next^.next;

     tempp^.next:=temp1;  first1^.next:=tempp;
     fl2:=true;
     end
     else fl2:=false;
     if temp1^.ter>temp1^.next^.ter then    begin   new(temppp);
     temppp:=temp1^.next;
     temp1^.next:=temp1^.next^.next;

     temppp^.next:=temp1;  first1^.next^.next:=temppp;
     fl3:=true
     end
     else fl3:=false;
     if temp1^.ter>temp1^.next^.ter then    begin   new(tempppp);
     tempppp:=temp1^.next;
     temp1^.next:=temp1^.next^.next;

     temppp^.next:=temp1;  first1^.next^.next^.next:=tempppp;
     fl4:=true
     end
     else fl4:=false;
 end;
 end;
procedure sorted2;
var fl1,fl2:boolean;
begin
   temp1:=first1;

   while temp1<>nil do
   begin
    fl1:=true; fl2:=true;
    temp3:=temp1^.podter;
   while fl1 and (temp3^.next<>nil) do begin
    if temp3^.podter>temp3^.next^.podter then    begin   new(t);
     t:=temp3^.next;
     temp3^.next:=temp3^.next^.next;
     t^.next:=temp3;
     fl1:=true ;
      temp1^.podter:=t;
     end
     else fl1:=false;

     {if temp3^.podter>temp3^.next^.podter then    begin   new(tt);
     tt:=temp3^.next;
     temp3^.next:=temp3^.next^.next;

     tt^.next:=temp3;  temp1^.podter^.next:=tt;
     fl2:=true;
     end
     else fl2:=false;}

     end;
  temp1:=temp1^.next;
end;
end;
procedure sorted3;
var fl1,fl2:boolean;
begin
   temp1:=first1;

   while temp1<>nil do
   begin
    temp3:=temp1^.podter;
    while temp3<>nil do
    begin
    fl1:=true; fl2:=true;
    temp5:=temp3^.podpod;
   while fl1 and (temp5^.next<>nil) do begin
    if temp5^.podpod>temp5^.next^.podpod then    begin   new(g);
     g:=temp5^.next;
     temp5^.next:=temp5^.next^.next;
     g^.next:=temp5;
     fl1:=true ;
      temp3^.podpod:=g;
     end
     else fl1:=false;

     {if temp3^.podter>temp3^.next^.podter then    begin   new(tt);
     tt:=temp3^.next;
     temp3^.next:=temp3^.next^.next;

     tt^.next:=temp3;  temp1^.podter^.next:=tt;
     fl2:=true;
     end
     else fl2:=false;}
     end;
     temp3:=temp3^.next;
     end;
  temp1:=temp1^.next;
end;
end;

procedure insert ;
var dop:adr1;el:string[25];m,i,k:byte;num:mas;
begin
  writeln('Введите имя нового термина: ');
  readln(el);
  new(dop);
  temp1:=first1;

  dop^.ter:=el;
  dop^.next:=first1;
  first1:=dop;
  writeln('На скольки страницах можно найти этот термин: ');
  readln(m);
   writeln('Введите номера этих страниц: ');
   for i:=1 to m do
  readln(num[i]);
  clrscr;
  k:=1;
  for i:=1 to m do
    dop^.strter[i]:=num[i];
end;
procedure insert2;
var dop:adr1;el:string[25];
dopp:adr3;ell:string[25];
m,i,k:byte;num:mas;
begin
  writeln('Введите имя подтермина: ');
  readln(ell);
  writeln('Введите термин, которому принадлежит данный подтермин: ');
  readln(el);
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  new(dopp);
  dopp^.podter:=ell;
  temp3:=temp1^.podter;
  dopp^.next:=temp1^.podter;
  temp1^.podter:=dopp;
  {dopp^.next:=temp3^.next;
  temp3^.next:=dopp;     }
  writeln('На скольки страницах содержится данный подтермин: ');
  readln(m);
   writeln('Введите эти страницы: ');
 for i:=1 to m do
  readln(num[i]);
  clrscr;
  for i:=1 to m do
    dopp^.strpodter[i]:=num[i];
end;
procedure insert3;
var el:string[25];
doppp:adr5;ell,elll:string[25];
m,i,k:byte;num:mas;
begin
  writeln('Введите имя подподтермина: ');
  readln(elll);
  writeln('Для какого подтермина он является подподтермином: ');
  readln(ell);
  writeln('Введите имя термина, которому принадлежит предыдущий подтермин: ');
  readln(el);
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  temp3:=temp1^.podter;
  while temp3^.next<>nil do
  begin
  if temp3^.podter=ell then break;
   temp3:=temp3^.next;
  end;
  new(doppp);
  doppp^.podpod:=elll;
  temp5:=temp3^.podpod;
  doppp^.next:=temp3^.podpod;
  temp3^.podpod:=doppp;
  {dopp^.next:=temp3^.next;
  temp3^.next:=dopp;     }
  writeln('На скольки страницах содержится данный подподтермин: ');
  readln(m);
   writeln('Введите номера этих страниц: ');
 for i:=1 to m do
  readln(num[i]);
  clrscr;
  for i:=1 to m do
    doppp^.strpodpod[i]:=num[i];
end;

procedure change;
var dop:adr1;el:string[25];
m,i,k,l,n:byte;num:mas;
procedure dob;  var l:byte;
begin
 i:=0;
  while temp1^.strter[i+1]<>0 do
   i:=i+1;
  writeln('Сколько страниц вы хотите добавить?');
  readln(m);   l:=1;
   writeln('Введите номера этих страниц:');
 for l:=1 to m do   begin
  readln(num[l]);

  temp1^.strter[l+i]:=num[l];   end;
end;
procedure cha;
begin
 i:=0;
  while temp1^.strter[i+1]<>0 do  begin
   i:=i+1;
  writeln('Введите новые страницы вместо ',temp1^.strter[i]);
  readln(num[i]);
  temp1^.strter[i]:=num[i] end
  end;
begin
writeln('Какой термин вы хотите изменить?');
  readln(el);
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  if temp1^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  writeln('Введите новое имя для термина:');
  readln(el);
  temp1^.ter:=el;
  writeln('Если вы хотите добавить страницы к термину - Нажмите <1>');
  writeln('Если вы хотите изменить или удалить страницу - Нажмите <2>');
  writeln('Для выхода - Нажмите <3>');
  readln(n);
  if n=1 then
    dob
    else if n=2 then cha ;
     clrscr;
end;
procedure change2;
var dop:adr1;el,ell:string[25];
m,i,k,l,n:byte;num:mas;
procedure dob;  var l:byte;
begin
 i:=0;
  while temp3^.strpodter[i+1]<>0 do
   i:=i+1;
  writeln('Сколько страниц вы хотите добавить?');
  readln(m);   l:=1;
   writeln('Введите номера этих страниц:');
 for l:=1 to m do   begin
  readln(num[l]);

  temp3^.strpodter[l+i]:=num[l];   end;
end;
procedure cha;
begin
 i:=0;
  while temp3^.strpodter[i+1]<>0 do  begin
   i:=i+1;
  writeln('Введите новый номер страницы вместо ',temp3^.strpodter[i]);
  readln(num[i]);
  temp3^.strpodter[i]:=num[i] end
  end;
begin
writeln('Какой подтермин вы хотите изменить?');
  readln(ell);
writeln('Какой термин включает этот подтермин?');
  readln(el);
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  if temp1^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  temp3:=temp1^.podter;
  while temp3^.next<>nil do
  begin
  if temp3^.podter=ell then break;
   temp3:=temp3^.next;
  end;
  if temp3^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  writeln('Введите новое имя для подтермина:');
  readln(ell);
  temp3^.podter:=ell;
  writeln('Если вы хотите добавить страницы к подтермину - Нажмите <1>');
  writeln('Если вы хотите изменить или удалить страницу - Нажмите <2>');
  writeln('Для выхода - Нажмите <3>');
  readln(n);
  if n=1 then
    dob
    else if n=2 then cha ;
     clrscr;
 end;
procedure change3;
var dop:adr1;el,ell,elll:string[25];
m,i,k,l,n:byte;num:mas;
procedure dob;  var l:byte;
begin
 i:=0;
  while temp5^.strpodpod[i+1]<>0 do
   i:=i+1;
  writeln('Сколько страниц вы хотите добавить?');
  readln(m);   l:=1;
   writeln('Введите номера этих страниц:');
 for l:=1 to m do   begin
  readln(num[l]);

  temp5^.strpodpod[l+i]:=num[l];   end;
end;
procedure cha;
begin
 i:=0;
  while temp5^.strpodpod[i+1]<>0 do  begin
   i:=i+1;
  writeln('Введите новые номера страниц вместо ',temp5^.strpodpod[i]);
  readln(num[i]);
  temp5^.strpodpod[i]:=num[i] end
  end;
begin
writeln('Какой подподтерин вы хотите изменить?');
  readln(elll);
writeln('Какой подтермин включает данный подподтермин?');
  readln(ell);
writeln('Какой термин включает предыдущий подтермин?');
  readln(el);
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  if temp1^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  temp3:=temp1^.podter;
  while temp3^.next<>nil do
  begin
  if temp3^.podter=ell then break;
   temp3:=temp3^.next;
  end;
  if temp3^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  temp5:=temp3^.podpod;
  while temp5^.next<>nil do
  begin
  if temp5^.podpod=elll then break;
   temp5:=temp5^.next;
  end;
  if temp5^.next=nil then begin
  writeln('Нет такого термина');
  readkey;
  exit;
  end;
  writeln('Введите новое имя для подподтермина:');
  readln(elll);
  temp5^.podpod:=elll;
  writeln('Если вы хотите добавить страницы к подподтермину - Нажмите <1>');
  writeln('Если вы хотите изменить или удалить страницу - Нажмите <2>');
  writeln('Для выхода - Нажмите <3>');
  readln(n);
  if n=1 then
    dob
    else if n=2 then cha ;
     clrscr;
end;
procedure delete;
var el:string[25];
 a:adr1;
begin
  writeln('Введите имя удаляемого термина:');
  readln(el);
  clrscr;
  temp1:=first1;
  if first1^.ter=el then
  first1:=temp1^.next
  else
  while temp1^.next<>nil do
  begin
  if temp1^.next^.ter=el then break;
   temp1:=temp1^.next;
  end;
  if temp1^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  a:=temp1^.next;
  temp1^.next:=temp1^.next^.next;
  end;
procedure delete2;
var el,ell:string[25];
 a:adr3;
begin

  writeln('Введите имя удаляемого подтермина:');
  readln(ell);
writeln('Какой термин включает в себя этот подтермин?');
  readln(el);
  clrscr;
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;

  if temp1^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  temp3:=temp1^.podter;
  if temp1^.podter^.podter=ell then
  temp1^.podter:=temp3^.next
  else
  while temp3^.next<>nil do
  begin
  if temp3^.next^.podter=ell then break;
   temp3:=temp3^.next;
  end;
  if temp3^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  a:=temp3^.next;
  temp3^.next:=a^.next;
  end;
procedure delete3;
var el,ell,elll:string[25];
 a:adr5;
begin

  writeln('Введите имя подподтермина для удаления:');
  readln(elll);
writeln('В каком подтермине он содержится?');
  readln(ell);
  writeln('Введите имя термина, содержащего данный подтермин:');
  readln(el);
  clrscr;
  temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;
  end;
  if temp1^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  temp3:=temp1^.podter;
  while temp3^.next<>nil do
  begin
  if temp3^.podter=ell then break;
   temp3:=temp3^.next;
  end;
  if temp3^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  temp5:=temp3^.podpod;
  if temp3^.podpod^.podpod=elll then
  temp3^.podpod:=temp5^.next
  else
  while temp5^.next<>nil do
  begin
  if temp5^.next^.podpod=elll then break;
   temp5:=temp5^.next;
  end;
  if temp5^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  a:=temp5^.next;
  temp5^.next:=a^.next;
  end;
procedure termin;
var el:string[25];
begin
writeln('Введите имя термина, который вы хотите найти: ');
readln(el);
clrscr;
writeln('Результаты поиска:');
temp1:=first1;
  while temp1^.next<>nil do
  begin
  if temp1^.ter=el then break;
   temp1:=temp1^.next;  end;
  if temp1^.next=nil then begin
  writeln('Неправильный ввод');
  readkey;
  exit;
  end;
  temp3:=temp1^.podter;
    writeln;
    write('  ',temp1^.ter);
    for i:=wherex to  50 do
      write('.');
    for n:=1 to 6 do
      if temp1^.strter[n]<>0 then
        write(' [',temp1^.strter[n],']');
    writeln;
    while temp3<>nil do
    begin
      temp5:=temp3^.podpod;writeln;
       write('      ',temp3^.podter);
       for i:=wherex to  50 do
       write('.');
       for n:=1 to 6 do
         if temp3^.strpodter[n]<>0 then
           write(' [',temp3^.strpodter[n],']');
       writeln;
       writeln;
       while temp5<>nil do
       begin
         write('          ',temp5^.podpod);
         for i:=wherex to  50 do
         write('.');
         for n:=1 to 6 do
           if temp5^.strpodpod[n]<>0 then
             write(' [',temp5^.strpodpod[n],']');
         writeln;
         temp5:=temp5^.next
       end;
       temp3:=temp3^.next
  end;
  readln;
 clrscr;
end;
procedure podtermin;
var el:string[25];
begin
  writeln('Введите имя искомого подтермина:');
  readln(el);
  clrscr;
  writeln('Результаты поиска:');
  temp1:=first1;
  while temp1<>nil do
  begin
    temp3:=temp1^.podter;
    while temp3<>nil do
    begin
      if temp3^.podter=el
      then begin
        writeln;
        write('  ',temp1^.ter);
        for i:=wherex to  50 do
          write('.');
        for n:=1 to 6 do
          if temp1^.strter[n]<>0 then
            write(' [',temp1^.strter[n],']');
        writeln;

        temp5:=temp3^.podpod;writeln;
       write('      ',temp3^.podter);
       for i:=wherex to  50 do
       write('.');
       for n:=1 to 6 do
         if temp3^.strpodter[n]<>0 then
           write(' [',temp3^.strpodter[n],']');
       writeln;
       writeln;
       while temp5<>nil do
       begin
         write('          ',temp5^.podpod);
         for i:=wherex to  50 do
         write('.');
         for n:=1 to 6 do
           if temp5^.strpodpod[n]<>0 then
             write(' [',temp5^.strpodpod[n],']');
         writeln;
         temp5:=temp5^.next
       end;
        end;
        temp3:=temp3^.next;
      end;
     temp1:=temp1^.next;
   end;
   readln;
   clrscr;
end;
procedure podpod;
var el:string[25]; l:byte;
begin
  textcolor(15);
  writeln('Введите имя искомого подподтермина:');
  readln(el);
  clrscr;
  writeln('Результаты поиска:');
  temp1:=first1;
  while temp1<>nil do
  begin
    temp3:=temp1^.podter;
    while temp3<>nil do
    begin
      temp5:=temp3^.podpod;
      for l:=1 to 2 do
      begin

      if temp5^.podpod=el
      then begin
        writeln;
        write('  ',temp1^.ter);
        for i:=wherex to  50 do
          write('.');
        for n:=1 to 6 do
          if temp1^.strter[n]<>0 then
            write(' [',temp1^.strter[n],']');
        writeln;

        temp5:=temp3^.podpod;
        if l=2 then temp5:=temp5^.next;
        writeln;
       write('      ',temp3^.podter);
       for i:=wherex to  50 do
       write('.');
       for n:=1 to 6 do
         if temp3^.strpodter[n]<>0 then
           write(' [',temp3^.strpodter[n],']');
       writeln;
       writeln;

         write('          ',temp5^.podpod);
         for i:=wherex to  50 do
         write('.');
         for n:=1 to 6 do
           if temp5^.strpodpod[n]<>0 then
             write(' [',temp5^.strpodpod[n],']');
         writeln;

       end;
       temp5:=temp5^.next
        end;
        temp3:=temp3^.next;
      end;
     temp1:=temp1^.next;
   end;
   readln;
  clrscr;
 end;
procedure inter(l:byte;n:byte);
begin
  textmode(co80);
  clrscr;

  textcolor(15);
  clrscr;
  k:=1;
  gotoxy(1,2);
  case l of
    1:  write('');
    2:  write('Выберите опцию поиска');
    3:  write('Выберите, что вставлять ');
    4:  write('Выберите, что изменять');
    5:  write('Выберите, что удалять');
    6:  write('Выберите, что искать');
  end;
  kod:=' ';
  while kod<>#13 do
  begin
    for i:=1 to n do
    begin
      if i=k then
      begin
        textcolor(14)
      end
      else
      begin
        textcolor(15)
      end;
      gotoxy(1,i+2);
      case l of
        1:  write(stor1[i]);
        2:  write(stor2[i]);
        3:  write(stor3[i]);
        4:  write(stor3[i]);
        5:  write(stor3[i]);
        6:  write(stor4[i])
      end;
    end;
    kod:=readkey;
    if kod=#0 then
    begin
      kod:=readkey;
      if kod=#72 then
      begin
        if k>1 then
          k:=k-1
        else
          k:=n
      end;
      if kod=#80 then
      begin
        if k<n then
          k:=k+1
        else
          k:=1
      end
    end
  end;
end;
procedure answer;
var fl:boolean;
begin
 fl:=true;
  while fl do begin
  inter(1,7);
  regim:=k;
  case k of
    1:   begin
           clrscr;
           clrscr;
            print;
            readln;
            clrscr;
           end;
    2:    begin
          inter(2,2);
          if k=1 then
          begin
            clrscr;
            clrscr;
            sorted;
            sorted2;
            sorted3;
            print;
            readln;
            clrscr;
          end
          else
          begin
            clrscr;
            clrscr;
            form;
            print;
            readln;
            clrscr;
          end;end;

    3:   begin
          inter(4,3);
          case k of
            1:  begin
            clrscr;
            clrscr;
            change;
            print;
            readln;
            clrscr;
          end;
            2:   begin
            clrscr;
            clrscr;
            change2;
            print;
            readln;
            clrscr;
          end;
            3:   begin
            clrscr;
            clrscr;
            change3;
            print;
            readln;
            clrscr;
          end;
          end;
        end;


    4: begin
          inter(5,3);
          case k of
            1:  begin
            clrscr;
            clrscr;
            delete;
            print;
            readln;
            clrscr;
          end;
            2:   begin
            clrscr;
            clrscr;
            delete2;
            print;
            readln;
            clrscr;
          end;
            3:   begin
            clrscr;
            clrscr;
            delete3;
            print;
            readln;
            clrscr;
          end;
          end;
        end;


    5:   begin
          inter(3,3);
          case k of
            1:  begin
            clrscr;
            clrscr;
            insert;
            print;
            readln;
            clrscr;
          end;
            2:   begin
            clrscr;
            clrscr;
            insert2;
            print;
            readln;
            clrscr;
          end;
            3:   begin
            clrscr;
            clrscr;
            insert3;
            print;
            readln;
            clrscr;
          end;
          end;
        end;

    6:   begin
          inter(6,3);
          case k of
            1:  begin
            clrscr;
            clrscr;
            termin;
            clrscr;
          end;
            2:   begin
            clrscr;
            clrscr;
            podtermin;
            clrscr;
          end;
            3:   begin
            clrscr;
            clrscr;
            podpod;
            clrscr;
          end;
          end;
        end;
    7:   fl:=false;
  end
  end;
end;
begin
TextAttr:=11;
CursorOff;
form; clrscr;
answer;
clrscr;
end.
