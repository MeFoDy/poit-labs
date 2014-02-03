uses crt, graph;

type point = record
        x:integer;
        y:integer;
end;
type coord = record
        x:real;
        y:real;
end;
window = array [1..12] of point;
wind = array[1..4] of point;

var o:window;
o1:wind;
gd,gm:smallint;
nach,kon:coord;
x,y:integer;

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

//######################## OTSECHKA ##############################
procedure otsec(o:wind; p1,p2:coord);
var d,a1,a2:coord;
n,w:coord;
k,i:integer;
tin,tout,t:real;
r1,r2:coord;
label g1,g2,g3,g4;
begin
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
        r1:=p1;
        r2:=p2;
        p2.x:=p1.x+tout*d.x;
        p2.y:=p1.y+tout*d.y;
        p1.x:=p1.x+tin*d.x;
        p1.y:=p1.y+tin*d.y;
        if not ((abs(r1.x-p1.x)<eps) and (abs(r1.y-p1.y)<eps)) then
          Line(round(r1.x),round(r1.y),round(p1.x),round(p1.y));
        if not ((abs(r2.x-p2.x)<eps) and (abs(r2.y-p2.y)<eps)) then
          Line(round(r2.x),round(r2.y),round(p2.x),round(p2.y));

      end
      else Line(round(p1.x),round(p1.y),round(p2.x),round(p2.y));
  end;
  g4:

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
// PROGRAM ------------------------------------------------------
begin
  gd:=detect;
  gm:=0;
  initgraph(gd,gm,'');

  nach.x:=100;
  nach.y:=100;
  kon.x:=800;
  kon.y:=600;

  x:=100;
  y:=100;

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

  o1[1].x:=100+x;  o1[1].y:=y;
  o1[2].x:=300+x;  o1[2].y:=y;
  o1[3].x:=250+x;  o1[3].y:=150+y;
  o1[4].x:=150+x;  o1[4].y:=150+y;

  graph_wind(o);

  Otsec(o1,nach,kon);

  readkey;
  closegraph;
end.
