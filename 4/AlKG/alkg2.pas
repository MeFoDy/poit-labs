uses crt, graph;

type coord = record
        x:real;
        y:real;
end;
pol = array [1..6] of coord;
type point = record
        x:integer;
        y:integer;
end;
window = array [0..3] of integer;

const n=30;

var mas1, mas2: pol;
o1,o2,o3:window;
per:pol;
gd,gm:smallint;
mode:boolean;
num:char;
i,j:integer;
delta,temp:pol;

Procedure Prepare;
var i:integer;
x,y:integer;
begin
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');
  x:=100;
  y:=100;

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

  o1[0]:=200+x; o1[1]:=600+x;
  o1[2]:=100+y; o1[3]:=200+y;

  o2[0]:=400+x; o2[1]:=o1[1];
  o2[2]:=o1[3]; o2[3]:=300+y;

  o3[0]:=o1[0]; o3[1]:=o1[1];
  o3[2]:=o2[3]; o3[3]:=400+y;

end;

procedure err(str:string);
begin
  closegraph;
  writeln('Error with procedure <',str,'>.');
  readkey;
  halt;
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

//######################## RUT1 ##################################
procedure rut1(o:window; p:point; j:integer; var k:integer);
label t1,t2,t3;
begin
  k:=0;
  if j=0 then begin
    if p.x<o[0] then k:=k+8;
    t1:
    if p.x>o[1] then k:=k+4;
    t2:
    if p.y<o[2] then k:=k+2;
    t3:
    if p.y>o[3] then k:=k+1;
  end
  else
    if j=1 then  goto t1
    else
      if j=2 then goto t2
      else
        if j=3 then goto t3
        else err('rut1');
end;
//######################## RUT2 ##################################
procedure rut2(k1,k2:integer; var b:integer);
begin
  if (k1=k2) and (k2=0) then b:=1
  else
    if (k1 and k2)=0 then b:=2
    else b:=0;
end;
//######################## OTSECHKA ##############################
procedure otsec(o:window; p1,p2:point);
var j,temp:integer;
k1,k2,b,f,dva:integer;
m:real;
label q1,q2;
begin
  j:=0;
  dva:=8;
  f:=0;
  rut1(o,p2,j,k2);
  q1:
  rut1(o,p1,j,k1);
  rut2(k1,k2,b);
  if b=1 then Line(p1.x,p1.y,p2.x,p2.y)
  else
    if b=2 then begin
      if j=0 then
        if p1.x=p2.x then f:=1
        else m:=(p2.y-p1.y)/(p2.x-p1.x);
        if ((k1 and dva)=0) and ((k2 and dva)=0) then begin
          j:=j+1;
          dva:=dva div 2;
          q2:
          if j>3 then err('otsec')
          else goto q1;
        end
        else begin
          if (k1 and dva)=0 then begin
            temp:=p1.x; p1.x:=p2.x; p2.x:=temp;
            temp:=p1.y; p1.y:=p2.y; p2.y:=temp;
            temp:=k1; k1:=k2; k2:=temp;
          end;
          if j>1 then
            if f=0 then begin
              p1.x:=round(p1.x + (o[j]-p1.y)/m);
              p1.y:=o[j];
            end
            else p1.y:=o[j]
          else begin
            p1.y:=p1.y + round((o[j]-p1.x)*m);
            p1.x:=o[j];
          end;
          goto q2;
        end;

    end;
end;

Procedure graph_wind(o1,o2,o3:window);
begin
  SetColor(3);
  Line(o3[0],o3[3],o3[1],o3[3]);
  Line(o3[1],o3[3],o3[1],o1[2]);
  Line(o1[1],o1[2],o1[0],o1[2]);
  Line(o1[0],o1[2],o1[0],o1[3]);
  Line(o1[0],o1[3],o2[0],o2[2]);
  Line(o2[0],o2[2],o2[0],o2[3]);
  Line(o2[0],o2[3],o3[0],o2[3]);
  Line(o3[0],o2[3],o3[0],o3[3]);
  SetColor(15);
end;

Procedure Otris(t1:pol);
var i,q:integer;
p1,p2:point;
begin
  if mode then cleardevice;
  for i:=1 to 6 do begin
        if i=6 then q:=1 else q:=i+1;
        p1.x:=round(t1[i].x);
        p1.y:=round(t1[i].y);
        p2.x:=round(t1[q].x);
        p2.y:=round(t1[q].y);
        Otsec(o1,p1,p2);
        Otsec(o2,p1,p2);
        Otsec(o3,p1,p2);
        graph_wind(o1,o2,o3);
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
