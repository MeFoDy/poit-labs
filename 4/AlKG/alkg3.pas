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
window = array [1..12] of point;
wind = array[1..4] of point;

const n=30;

var mas1, mas2: pol;
o1,o2,o3,o4,o5,o6,o7,o8:wind;
o:window;
per:pol;
gd,gm:smallint;
mode:boolean;
num:char;
i,j:integer;
delta,temp:pol;

const eps = 0.001;

procedure opred(p1,p2,f:coord; var n,w:coord);
var k,b:real;
begin

  if p1.x=p2.x then begin
    if p2.y<p1.y then n.x:=1
    else n.x:=-1;
    n.y:=0;
  end
  else begin
    k:=(p1.y - p2.y)/(p1.x - p2.x);
    b:=p1.y - k*p1.x;
    // y = k*x + b;
    // - k*x + y - b = 0;
    if p2.y<p1.y then n.x:=abs(k)
    else n.x:=-abs(k);
    if p2.x>p1.x then n.y:=1
    else n.y:=-1;
  end;

  w.x:=-p2.x+f.x;
  w.y:=-p2.y+f.y;
end;

function scal(p1,p2:coord):real;
begin
  scal:=p1.x*p2.x+p1.y*p2.y;
end;

Procedure Prepare;
var i:integer;
x,y:integer;
begin
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');
  x:=110;
  y:=10;

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

  o[1].x:=100+x;  o[1].y:=y;
  o[2].x:=300+x;  o[2].y:=y;
  o[3].x:=250+x;  o[3].y:=150+y;
  o[4].x:=400+x;  o[4].y:=100+y;
  o[5].x:=400+x;  o[5].y:=300+y;
  o[6].x:=250+x;  o[6].y:=250+y;
  o[7].x:=300+x;  o[7].y:=400+y;
  o[8].x:=100+x;  o[8].y:=400+y;
  o[9].x:=150+x;  o[9].y:=250+y;
  o[10].x:=x;  o[10].y:=300+y;
  o[11].x:=x;  o[11].y:=100+y;
  o[12].x:=150+x;  o[12].y:=150+y;

  o1[1].x:=1; o1[1].y:=1;
  o1[2].x:=1000; o1[2].y:=1;
  o1[3].x:=1000; o1[3].y:=y;
  o1[4].x:=1; o1[4].y:=y;

  o2[1].x:=1; o2[1].y:=y;
  o2[2].x:=x; o2[2].y:=y;
  o2[3].x:=x; o2[3].y:=y+400;
  o2[4].x:=1; o2[4].y:=y+400;

  o3[1].x:=1; o3[1].y:=y+400;
  o3[2].x:=1000; o3[2].y:=y+400;
  o3[3].x:=1000; o3[3].y:=1000;
  o3[4].x:=1; o3[4].y:=1000;

  o4[1].x:=x+400; o4[1].y:=y;
  o4[2].x:=1000; o4[2].y:=y;
  o4[3].x:=1000; o4[3].y:=y+400;
  o4[4].x:=x+400; o4[4].y:=y+400;

  o5[1].x:=x; o5[1].y:=y;
  o5[2]:=o[1];
  o5[3]:=o[12];
  o5[4]:=o[11];

  o6[1].x:=x+400; o6[1].y:=y;
  o6[2]:=o[4];
  o6[3]:=o[3];
  o6[4]:=o[2];

  o7[1].x:=x+400; o7[1].y:=y+400;
  o7[2]:=o[7];
  o7[3]:=o[6];
  o7[4]:=o[5];

  o8[1].x:=x; o8[1].y:=y+400;
  o8[2]:=o[10];
  o8[3]:=o[9];
  o8[4]:=o[8];

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

// OTRISOVKA POLNOGO OKNA ========================================
Procedure graph_wind(o:window);
var i,q:integer;
begin
  setcolor(4);
  for i:=1 to 12 do begin
    if i=12 then q:=1 else q:=i+1;
    Line(o[i].x,o[i].y,o[q].x,o[q].y);
  end;
  setcolor(15);
end;

//######################## OTSECHKA ##############################
procedure otsec(o:wind; z1,z2:point);
var d,a1,a2:coord;
n,w:coord;
k,i:integer;
tin,tout,t:real;
p1,p2:coord;
label g1,g2,g3,g4;
begin
  p1.x:=z1.x; p1.y:=z1.y;
  p2.x:=z2.x; p2.y:=z2.y;

  d.x:=p2.x - p1.x;
  d.y:=p2.y - p1.y;
  tin:=0;
  tout:=1;
  i:=1;

  g1:
  a1.x:=o[i].x;
  a1.y:=o[i].y;
  if i=4 then begin
        a2.x:=o[1].x;
        a2.y:=o[1].y;
  end else begin
        a2.x:=o[i+1].x;
        a2.y:=o[i+1].y;
  end;

  g2:
  opred(a1,a2,p1,n,w);
  if abs(scal(d,n))<eps then
    if scal(w,n)>=0 then goto g3
    else goto g4
  else begin
    t:=-scal(w,n)/scal(d,n);
    if scal(d,n)>=0 then begin
      if tin<t then tin:=t;
    end
    else begin
      if tout>t then tout:=t;
    end;

    g3:
    i:=i+1;
    if i<=4 then goto g1 else
      if tin<=tout then begin
        p2.x:=p1.x+tout*d.x;
        p2.y:=p1.y+tout*d.y;
        p1.x:=p1.x+tin*d.x;
        p1.y:=p1.y+tin*d.y;
        Line(round(p1.x),round(p1.y),round(p2.x),round(p2.y));

      end;
  end;
  g4:

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
        Otsec(o4,p1,p2);
        Otsec(o5,p1,p2);
        Otsec(o6,p1,p2);
        Otsec(o7,p1,p2);
        Otsec(o8,p1,p2);
        graph_wind(o);
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
