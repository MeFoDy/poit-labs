uses crt, graph;

type point = record
        x:integer;
        y:integer;
end;
window = array [0..3] of integer;

var o:window;
p1,p2,nach,kon:point;
gd,gm:smallint;

procedure err(str:string);
begin
  closegraph;
  writeln('Error with procedure <',str,'>.');
  readkey;
  halt;
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
procedure otsec(o:window; var p1,p2:point);
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
              p1.y:=o[j];
              p1.x:=round(p1.x + (o[j]-p1.y)/m);
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

Procedure graph_wind(o:window);
begin
  Line(o[0],o[2],o[0],o[3]);
  Line(o[1],o[2],o[1],o[3]);
  Line(o[0],o[2],o[1],o[2]);
  Line(o[0],o[3],o[1],o[3]);
end;

begin
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');

  o[0]:=200; o[1]:=600;
  o[2]:=100; o[3]:=500;

  nach.x:=210;
  nach.y:=110;
  kon.x:=800;
  kon.y:=800;

  graph_wind(o);

  Otsec(o,nach,kon);

  readkey;
  closegraph;
end.
