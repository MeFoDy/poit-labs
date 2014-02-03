uses graph,crt;
type point = record
        x,y,z:integer;
end;

osn = array [0..5] of point;

matrix = array [0..2,0..2] of double;

var o1,o2,t1,t2:osn;
grA,radA,grB,radB:double;
i:integer;
c:char;
gd,gm:smallint;
x,y:integer;
sign:integer;
os,t:osn;
chk:array[0..7] of boolean;
norm:array[0..7] of point;
v,tempV:point;
rez:integer;

function vector(a,b:point):point;
begin
  vector.x:=(a.y*b.z-a.z*b.y) div 10;
  vector.y:=(a.z*b.x-a.x*b.z) div 10;
  vector.z:=(a.x*b.y-a.y*b.x) div 10;
end;

function scal(a,b:point):integer;
begin
  scal:=a.x*b.x+a.y*b.y+a.z*b.z;
end;

function check(a,b,c:point):boolean;
var lA,lB:double;
begin
  {lA:=sqrt(a.x*a.x+a.y*a.y+a.z*a.z);
  lB:=sqrt(b.x*b.x+b.y*b.y+b.z*b.z);
  c:=scal(a,b)/(lA*lB);
  if c>0 then check:=true
    else check:=false; }
  check:=((a.x*b.y+a.y*c.x+b.x*c.y-b.y*c.x-a.y*b.x-c.y*a.x)>0);
end;

procedure prepare;
begin
  clrscr;
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');

  setcolor(green);

  grA:=pi/4;
  grB:=pi/2;
  sign:=1;

  rez:=1;

  x:=0;
  y:=0;

  o1[0].x:=x;
  o1[0].y:=y+100;
  o1[0].z:=100;
  o1[1].x:=x+200;
  o1[1].y:=y;
  o1[1].z:=100;
  o1[2].x:=x+400;
  o1[2].y:=y+100;
  o1[2].z:=100;
  o1[3].x:=x+400;
  o1[3].y:=y+300;
  o1[3].z:=100;
  o1[4].x:=x+200;
  o1[4].y:=y+400;
  o1[4].z:=100;
  o1[5].x:=x;
  o1[5].y:=y+300;
  o1[5].z:=100;

  o2[0].x:=x;
  o2[0].y:=y+100;
  o2[0].z:=600;
  o2[1].x:=x+200;
  o2[1].y:=y;
  o2[1].z:=600;
  o2[2].x:=x+400;
  o2[2].y:=y+100;
  o2[2].z:=600;
  o2[3].x:=x+400;
  o2[3].y:=y+300;
  o2[3].z:=600;
  o2[4].x:=x+200;
  o2[4].y:=y+400;
  o2[4].z:=600;
  o2[5].x:=x;
  o2[5].y:=y+300;
  o2[5].z:=600;

  os[0].x:=100; os[0].y:=0; os[0].z:=0;
  os[1].x:=0; os[1].y:=100; os[1].z:=0;
  os[2].x:=0; os[2].y:=0; os[2].z:=100;
  os[3].x:=0; os[3].y:=0; os[3].z:=0;

  v.x:=round(20*cos(grB)*sin(grA));
  v.y:=round(20*sin(grB));
  v.z:=round(20*cos(grB)*cos(grA));
  v.x:=200; v.y:=0; v.z:=0;

end;


function r(a,b:double):matrix;
var m:matrix;
begin
  m[0,0]:=cos(b);
  m[0,1]:=sin(a)*sin(b);
  m[0,2]:=-cos(a)*sin(b);
  m[1,0]:=0;
  m[1,1]:=cos(a);
  m[1,2]:=sin(a);
  m[2,0]:=sin(b);
  m[2,1]:=-sin(a)*cos(b);
  m[2,2]:=cos(a)*cos(b);
  r:=m;
end;

function rV(a,b:double):matrix;
var m:matrix;
begin
  m[0,0]:=cos(b);
  m[0,1]:=sin(a)*sin(b);
  m[0,2]:=cos(a)*sin(b);
  m[1,0]:=0;
  m[1,1]:=cos(a);
  m[1,2]:=-sin(a);
  m[2,0]:=-sin(b);
  m[2,1]:=sin(a)*cos(b);
  m[2,2]:=cos(a)*cos(b);
  rV:=m;
end;

procedure style(chk1,chk2:boolean; rez:integer);
begin
if (chk1) or (chk2)  then
      case rez of
      1:setlinestyle(SolidLn,0,NormWidth);
      2:setcolor(green);
      end
    else
      case rez of
      1:setlinestyle(DashedLn,0,NormWidth);
      2:setcolor(black);
      end;
end;

procedure otris(o1,o2:osn);
var i,d,f:integer;
begin
  cleardevice;
  d:=500;
  f:=100;

  for i:=0 to 5 do begin
    style(chk[7],chk[i],rez);
    Line(o1[i].x+d,o1[i].y+f, o1[(i+1) mod 6].x+d, o1[(i+1) mod 6].y+f);
  end;

  for i:=0 to 5 do begin
    if (chk[6]) or (chk[i]) then
      setlinestyle(SolidLn,0,NormWidth)
    else setlinestyle(DashedLn,0,NormWidth);
    Line(o2[i].x+d,o2[i].y+f, o2[(i+1) mod 6].x+d, o2[(i+1) mod 6].y+f);
  end;


  for i:=0 to 5 do begin
    if (chk[i]) or (chk[i-1])  then
      setlinestyle(SolidLn,0,NormWidth)
    else setlinestyle(DashedLn,0,NormWidth);
    Line(o1[i].x+d,o1[i].y+f, o2[i].x+d, o2[i].y+f);
  end;

  for i:=0 to 2 do begin
    case i of
      0:setcolor(red);
      1:setcolor(blue);
      2:setcolor(yellow);
    end;
    Line(t[3].x+d,t[3].y+f,t[i].x+d,t[i].y+f);
  end;
  setcolor(green);
  //Line(d,f,tempV.x+d,tempV.y+f);
  delay(40);
end;

procedure umnozh(m:matrix; p:point; var x,y,z:integer);
begin
  x:=round(p.x*m[0,0] + p.y*m[1,0] + p.z*m[2,0]);
  y:=round(p.x*m[0,1] + p.y*m[1,1] + p.z*m[2,1]);
  z:=round(p.x*m[0,2] + p.y*m[1,2] + p.z*m[2,2]);
end;

procedure obrab(b:double);
var i:integer;
v1,v2:point;
begin
  radA:=arctan(sin(b));
  if (b>2*pi) then begin
    grB:=grB-2*pi;
    b:=b-2*pi;
  end;

  for i:=0 to 5 do begin
    umnozh(r(radA,b),o1[i], t1[i].x, t1[i].y, t1[i].z);
    umnozh(r(radA,b),o2[i], t2[i].x, t2[i].y, t2[i].z);
  end;
  for i:=0 to 3 do
    umnozh(r(radA,b),os[i], t[i].x, t[i].y, t[i].z);

  //umnozh(r(radA,b),v, tempV.x, tempV.y, tempV.z);
  //writeln(tempV.x,' ',tempV.y,' ',tempV.z);

  for i:=0 to 5 do begin
    v1.x:=t2[(i+1) mod 6].x-t2[i].x;
    v1.y:=t2[(i+1) mod 6].y-t2[i].y;
    v1.z:=t2[(i+1) mod 6].z-t2[i].z;

    v2.x:=t1[(i+1) mod 6].x-t2[(i+1) mod 6].x;
    v2.y:=t1[(i+1) mod 6].y-t2[(i+1) mod 6].y;
    v2.z:=t1[(i+1) mod 6].z-t2[(i+1) mod 6].z;

    norm[i]:=vector(v1,v2);
  end;
  v1.x:=t2[2].x-t2[3].x;
  v1.y:=t2[2].y-t2[3].y;
  v1.z:=t2[2].z-t2[3].z;

  v2.x:=t2[1].x-t2[2].x;
  v2.y:=t2[1].y-t2[2].y;
  v2.z:=t2[1].z-t2[2].z;
  norm[6]:=vector(v1,v2);

  v1.x:=t1[2].x-t1[1].x;
  v1.y:=t1[2].y-t1[1].y;
  v1.z:=t1[2].z-t1[1].z;

  v2.x:=t1[3].x-t1[2].x;
  v2.y:=t1[3].y-t1[2].y;
  v2.z:=t1[3].z-t1[2].z;
  norm[7]:=vector(v1,v2);

  //writeln(norm[7].x,' ',norm[7].y,' ',norm[7].z);

  for i:=0 to 5 do
    chk[i]:=check(t2[i],t2[(i+1) mod 6],t1[(i+1) mod 6]);
  chk[6]:=check(t2[3],t2[2],t2[1]);
  chk[7]:=check(t1[1],t1[2],t1[3]);

end;

begin
  prepare;
  t1:=o1;
  t2:=o2;
  while (c<>#27) do begin
    obrab(grB);
    otris(t1,t2);
    c:=readkey;
    grB:=grB+pi/30;
  end;
  closegraph;
end.
