Program obrab_och;
uses
        crt, heaptrc;

type
        pos_ch = ^och_ch;
        och_ch = record
          chislo : integer;
          next_ch : pos_ch;
        end;

        pos_str = ^och_str;
        och_str = record
          id : char;
          head_c : pos_ch;
          priority : byte;
          next_str : pos_str;
        end;

var
        inp : text;
        outp : text;
        ololo, all : longint;
        nach, kon : longint;
        k, n, sch : integer;
        A : byte;
        och : och_str;
        stroka : och_ch;
        temp_s, temp1_s, temp2_s, head_s, prev_s, prev_prev_s : pos_str;
        temp_c, prev_c : pos_ch;
        flag, t, ooo1, perem : boolean;

//Инициализация числа К и привязка к текстовому файлу
procedure initiate;
begin
  assign(inp,'input.txt');
  assign(outp,'output.txt');
  reset(inp);
  rewrite(outp);
  clrscr;
  sch:=0;
  all:=0;
  ololo:=0;
  write('Введите время такта: ');
  readln(k);
  write('Введите время ввода-вывода: ');
  readln(n);
  A:=65;
  new(head_s);
  temp_s:=head_s;
  prev_s:=temp_s;
end;

//Просмотр текущего состояния строк
procedure Prosmotr;
var temp:pos_str;
temp1:pos_ch;
begin
  temp:=head_s^.next_str;
  while temp<>NIL do begin
    write(temp^.id, ' ');
    temp1:=temp^.head_c^.next_ch;
    while temp1<>NIL do begin
      write(temp1^.chislo,' ');
      temp1:=temp1^.next_ch;
    end;
    writeln;
    temp:=temp^.next_str;
  end;
  writeln;

end;

//Создание числовой очереди из строки
procedure create_line;
var
        prior:byte;
        ch:integer;
begin
  read(inp, prior);
  new(temp_s);
  temp_s^.next_str:=NIL;
  temp_s^.id:=chr(A);
  temp_s^.priority:=prior;
  prev_s^.next_str:=temp_s;
  prev_s:=temp_s;

  new(temp_s^.head_c);
  prev_c:=temp_s^.head_c;
  while not(eoln(inp)) do begin
    read(inp,ch);
    new(temp_c);
    temp_c^.next_ch:=NIL;
    temp_c^.chislo:=ch;
    prev_c^.next_ch:=temp_c;
    prev_c:=temp_c;
    {
    write(outp,temp_c^.chislo,' ');
    }
  end;
  {
  writeln(outp,chr(A));
  }
end;

//Процедура сортировки очереди
procedure sort_line;
var temp:pos_str;
begin
  flag:=true;
  temp_s:=head_s^.next_str^.next_str;
  prev_s:=head_s^.next_str;
  prev_prev_s:=head_s;
  while temp_s<>NIL do begin
    if temp_s^.priority<prev_s^.priority then begin
      temp:=temp_s^.next_str;
      prev_prev_s^.next_str:=temp_s;
      temp_s^.next_str:=prev_s;
      prev_s^.next_str:=temp;

      flag:=false;

      temp:=prev_s;
      prev_s:=temp_s;
      temp_s:=temp;
    end;
    temp_s:=temp_s^.next_str;
    prev_s:=prev_s^.next_str;
    prev_prev_s:=prev_prev_s^.next_str;
  end;
end;

//Проверка возможности удаления
procedure del;
var q : pos_str;
l : pos_ch;
begin
  perem:=false;
  if temp_s^.head_c^.next_ch^.chislo<=-n then begin
    ololo:=ololo+abs(n-abs(temp_s^.head_c^.next_ch^.chislo));
    l:=temp_s^.head_c^.next_ch;
    temp_s^.head_c^.next_ch:=temp_s^.head_c^.next_ch^.next_ch;
    dispose(l);
  end;
  if temp_s^.head_c^.next_ch=NIL then begin
    prev_s^.next_str:=temp_s^.next_str;
    dispose(temp_s^.head_c);
    dispose(temp_s);
    temp_s:=prev_s^.next_str;
    perem:=true;
    {ooo1:=false;}
  end;
  if head_s^.next_str=NIL then  begin
    flag:=true;
    dispose(head_s^.next_str);
    dispose(head_s);
  end;
end;

//Операция обработки очереди
procedure ooo;
begin
  if temp_s^.head_c^.next_ch^.chislo>=-n then begin
    if temp_s^.head_c^.next_ch^.chislo>0 then dec(temp_s^.head_c^.next_ch^.chislo,k)
      else dec(temp_s^.head_c^.next_ch^.chislo,n);
    t:=true;
    temp1_s:=temp_s;
    temp2_s:=prev_s;
  end
  else del;
end;

//Перемещения обработанной строки в конец очереди
procedure smena(temp, prev : pos_str);
var tt1,pp1,q : pos_str;
kol:integer;
begin
  tt1:=temp;
  pp1:=prev;
  kol:=0;
  while (tt1^.next_str<>NIL) and (tt1^.priority=tt1^.next_str^.priority) do begin
    tt1:=tt1^.next_str;
    pp1:=pp1^.next_str;
    kol:=kol+1;
  end;
  if kol<>0 then begin
    q:=tt1^.next_str;
    prev^.next_str:=temp^.next_str;
    tt1^.next_str:=temp;
    temp^.next_str:=q;
  end;
end;

//Обработка строк
procedure obrabotka;
begin
  flag:=false;
  prev_s:=head_s;
  temp_s:=head_s^.next_str;
  t:=false;
  perem:=false;

  while temp_s<>NIL do begin

    if t then del
    else ooo;
    if not(perem) then begin
      if (temp_s<>NIL) then temp_s:=temp_s^.next_str
        else temp_s:=NIL;
        prev_s:=prev_s^.next_str;
    end
    else begin
      if (temp_s<>NIL) then
      temp_s:=prev_s^.next_str;
    end;
  end;

  if t then smena(temp1_s,temp2_s);

  if head_s=NIL then flag:=true;
  sch:=sch+1;
end;

begin
  initiate;

  //Создание очереди
  while not(eof(inp)) do begin
    create_line;
    A:=A+1;
  end;

  //Сортировка очереди по приоритетам
  flag:=false;
  if (head_s^.next_str=NIL) or (head_s^.next_str^.next_str=NIL) then flag:=true;
  while not(flag) do sort_line;

  prosmotr;

  flag:=false;
  while not(flag) do begin
    all:=all+k;
    {prosmotr;}
    obrabotka;
  end;
  writeln(outp,'Всего единиц времени ожидания ',ololo);
  writeln(outp,'КПД системы: ',(all-ololo)/all*100:0:5,'%');
  close(outp);
end.
