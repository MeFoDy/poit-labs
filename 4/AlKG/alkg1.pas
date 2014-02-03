uses crt, graph;

type coord = record
        x:real;
        y:real;
end;
pol = array [1..6] of coord;

const n=30;

var mas1, mas2: pol;
per:pol;
gd,gm:smallint;
mode:boolean;
num:char;
i,j:integer;
delta,temp:pol;

Procedure Prepare;
var i:integer;
begin
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');

  mas1[6].x:=40;   mas1[6].y:=40;
  mas1[5].x:=40;   mas1[5].y:=80;
  mas1[4].x:=100;  mas1[4].y:=100;
  mas1[3].x:=140;  mas1[3].y:=80;
  mas1[2].x:=140;  mas1[2].y:=40;
  mas1[1].x:=100;  mas1[1].y:=20;

  mas2[1].x:=600;       mas2[1].y:=400;
  mas2[2].x:=550;       mas2[2].y:=420; // 2=3
  mas2[3].x:=550;       mas2[3].y:=420;
  mas2[4].x:=620;       mas2[4].y:=480;
  mas2[5].x:=680;       mas2[5].y:=440; // 5=6
  mas2[6].x:=680;       mas2[6].y:=440;

end;

Procedure Peregorodka;
var i:integer;
x,k,b:real;
begin
  x:=mas1[1].x + (mas2[1].x-mas1[1].x)/2;
  for i:=1 to 6 do begin
    per[i].x:=x;
    //y1-y2=k(x1-x2)
    k:=(mas1[i].y - mas2[i].y)/(mas1[i].x - mas2[i].x);
    b:=mas1[i].y - k*mas1[i].x;
    per[i].y:=k*x + b;
  end;
end;

Procedure Otris(t1:pol);
var i,q:integer;
begin
  if mode then cleardevice;
  for i:=1 to 6 do begin
        if i=6 then q:=1 else q:=i+1;
        Line(round(t1[i].x), round(t1[i].y), round(t1[q].x), round(t1[q].y));
  end;
end;


begin
  clrscr;
  writeln('Введите номер режима работы:');
  writeln('0. С отображением всех промежуточных фигур');
  writeln('1. Отображение без шлейфа');
  readln(num);
  if num='0' then mode:=false else mode:=true;

  Prepare;
  Peregorodka;

  for i:=1 to 6 do begin
    delta[i].x:=(per[i].x - mas1[i].x)/15;
    delta[i].y:=(per[i].y - mas1[i].y)/15;
  end;

  temp:=mas1;
  Otris(mas1);
  for i:=1 to 15 do begin
    for j:=1 to 6 do begin
      temp[j].x:=temp[j].x + delta[j].x;
      temp[j].y:=temp[j].y + delta[j].y;
    end;
    delay(100);
    Otris(temp);
  end;
  Otris(per);

  delay(1000);

  for i:=1 to 6 do begin
    delta[i].x:=(mas2[i].x - per[i].x)/15;
    delta[i].y:=(mas2[i].y - per[i].y)/15;
  end;

  temp:=per;
  for i:=1 to 15 do begin
    for j:=1 to 6 do begin
      temp[j].x:=temp[j].x + delta[j].x;
      temp[j].y:=temp[j].y + delta[j].y;
    end;
    delay(100);
    Otris(temp);
  end;
  Otris(mas2);

  readkey;
  closegraph;
end.
