Program NLO;
uses crt,graph;
var room,but:char;
GrD,GrM:integer;

Procedure Grafika(floor:integer);
begin
  GrD:=Detect;
  InitGraph(GrD,GrM,'');
  case floor of
    1:SetColor(Red);
    2:SetColor(Green);
    3:SetColor(Cyan);
  end;

  if floor=2 then begin
    SetLineStyle(0,0,3);
    MoveTo(100,400);
    LineRel(400,0); LineRel(0,200); LineRel(-400,0); LineRel(0,-200);
    MoveTo(80,600);
    LineRel(20,0); LineRel(0,-20); LineRel(-20,0); LineRel(0,20);
    MoveTo(300,400);
    LineRel(0,20); MoveRel(0,20); LineRel(0,160);
    MoveTo(340,400);
    LineRel(0,110); MoveRel(0,20); LineRel(0,70);
    MoveTo(100,500);
    LineRel(100,0); MoveRel(20,0); LineRel(80,0);
    SetColor(White);
    SetTextStyle(DefaultFont,HorizDir,2);
    OutTextXY(150,350,'2 floor');
    SetTextStyle(DefaultFont,HorizDir,1);
    OutTextXY(85,585,'L');
    OutTextXY(410,510,'Room3');
    OutTextXY(150,450,'Sports-hall');
    OutTextXY(160,550,'Canteen');
    floor:=1;
  end;

  if floor=3 then begin
    SetLineStyle(0,0,3);
    MoveTo(100,400);
    LineRel(400,0); LineRel(0,200); LineRel(-400,0); LineRel(0,-200);
    MoveTo(80,600);
    LineRel(20,0); LineRel(0,-20); LineRel(-20,0); LineRel(0,20);
    MoveTo(100,550);
    LineRel(350,0); MoveRel(20,0); LineRel(30,0);
    MoveTo(430,600);
    LineRel(0,-10); MoveRel(0,-20); LineRel(0,-20);
    SetColor(White);
    SetTextStyle(DefaultFont,HorizDir,2);
    OutTextXY(150,350,'3 floor');
    SetTextStyle(DefaultFont,HorizDir,1);
    OutTextXY(85,585,'L');
    OutTextXY(190,465,'Prison');
    OutTextXY(450,580,'Room4');
    floor:=1;
  end;


  if floor=1 then begin
    SetColor(Red);
    SetLineStyle(0,0,3);
    MoveTo(100,100);
    LineTo(500,100); LineTo(500,300); LineTo(100,300); LineTo(100,100);
    MoveTo(80,300);
    LineRel(20,0); LineRel(0,-20); LineRel(-20,0); LineRel(0,20);
    MoveTo(100,200);
    LineRel(300,0); MoveRel(20,0); LineRel(80,0);
    MoveTo(300,100);
    LineRel(0,50); MoveRel(0,20); LineRel(0,30);
    MoveTo(140,300);
    LineRel(0,-60); LineRel(200,0); MoveRel(20,0); LineRel(100,0); LineRel(0,60);
    MoveTo(300,240);
    LineRel(0,30); MoveRel(0,20); LineRel(0,10);
    SetLineStyle(0,0,6); MoveTo(500,300); SetColor(White); LineRel(-40,0);
    SetTextStyle(DefaultFont,HorizDir,2);
    OutTextXY(150,50,'1 floor');
    SetTextStyle(DefaultFont,HorizDir,1);
    OutTextXY(150,150,'Room1');
    OutTextXY(370,150,'Room2');
    OutTextXY(170,260,'Toilet');
    OutTextXY(360,260,'Restroom');
    OutTextXY(470,310,'EXIT');
    OutTextXY(85,285,'L');
  end;

end;

procedure ok;
begin
  clrscr;
  SetColor(White);
  SetLineStyle(0,0,20);
  MoveTo(900,500);
  LineRel(40,0);
  Circle(1000,500,15);
  Arc(960,490,240,300,50);
  textcolor(2);
  gotoxy(20,10);
  writeln('CONGRATULATIONS! YOU ARE FREE!');
  repeat until keypressed;
  halt;
end;


procedure room1;
begin
  gotoxy(20,20);
  writeln('Go to Room2 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure room2;
begin
  gotoxy(20,20);
  writeln('Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure room3;
begin
  gotoxy(1,20);
  writeln('Go to Koridor - Go to Sports-hall - Go to Canteen - Goto Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure room4;
begin
  gotoxy(10,20);
  writeln('Go to Koridor - Goto Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure toilet;
begin
  gotoxy(20,20);
  writeln('Go to Restroom - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure restroom;
begin
  gotoxy(20,20);
  writeln('Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure koridor;
begin
  gotoxy(15,20);
  writeln('Go to Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure lift;
begin
  gotoxy(20,20);
  writeln('Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure canteen;
begin
  gotoxy(15,20);
  writeln('Goto Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure sportshall;
begin
  gotoxy(5,20);
  writeln('Go to Canteen - Goto Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;
end;

procedure turma;
begin
  gotoxy(1,20);
  writeln('Go to Room4 - Go to Koridor - Goto Lift - Press 1 - Go to Koridor - Go to Exit');
  readkey;
  ok;

end;

procedure first;
begin
  clrscr;
  gotoxy(20,5);
  Grafika(1);
  textcolor(4);
  writeln('Select the room:');
  writeln('0. Lift');
  writeln('6. Koridor');
  writeln('1. Room1');
  writeln('2. Room2');
  writeln('3. Toilet');
  writeln('4. Restroom');
  textcolor(7);
  room:=readkey;
  case room of
    '1': room1;
    '2': room2;
    '3': toilet;
    '4': restroom;
  end;
end;

procedure second;
begin
  clrscr;
  gotoxy(20,5);
  Grafika(2);
  textcolor(2);
  writeln('Select the room:');
  writeln('0. Lift');
  writeln('6. Koridor');
  writeln('1. Canteen');
  writeln('2. Room3');
  writeln('3. Sports-hall');
  textcolor(7);
  room:=readkey;
  case room of
    '1': canteen;
    '2': room3;
    '3': sportshall;
  end;

end;

procedure third;
begin
  clrscr;
  gotoxy(20,5);
  Grafika(3);
  textcolor(3);
  writeln('Select the room:');
  writeln('0. Lift');
  writeln('6. Koridor');
  writeln('1. Prison');
  writeln('2. Room4');
  textcolor(7);
  room:=readkey;
  case room of
    '1': turma;
    '2': room4;
  end;
end;

begin
  clrscr;
  gotoxy(20,5);
  writeln('Select color of the room, please:');
  textcolor(4);
  writeln('1. Red');
  textcolor(2);
  writeln('2. Green');
  textcolor(3);
  writeln('3. Blue');
  textcolor(7);
  but:=readkey;
  case but of
    '1': first;
    '2': second;
    '3': third;
  end;
  case room of
    '0':lift;
    '6':koridor;
  end;
  readkey;
end.
