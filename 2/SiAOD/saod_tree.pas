Program treetest;
Uses crt;
const x:integer=35;
      y:integer=2;
      d=30;
type
   tuk=^tree;
     tree=record
     key:integer;
     left,right:tuk;
     end;
Var root,temp:tuk;i,k,s:integer;
    f:boolean;
    kol: integer;
    a: array [0..1000] of integer;
    s1,s2,s3: string;
{procedure vstavki elementa v binarnoe derevo}
  procedure addtree(var temp:tuk; i:integer);
    begin
     if temp = nil then begin new(temp);
      temp^.left:=nil;  temp^.right:=nil;
      temp^.key:=i;
      end
     else
     if temp^.key>i then
       addtree(temp^.left,i)
      else
       if temp^.key<i then
         addtree(temp^.right,i)
        else begin
          Writeln('   Error   ');
          f:=false;
          end;
    kol:=kol+1;
  end;
 {Procedure pechati dereva}
  Procedure prtree(var temp:tuk;x,y,k:integer);
    begin
     inc(k,2);
     gotoxy(x,y);
     write(temp^.key);
     if temp^.left<>nil then begin
       gotoxy(x-1,y+1);
       writeln('/');
       prtree(temp^.left,(x-d div k),y+3,k)
      end;
     if temp^.right<>nil then begin
       gotoxy(x+1,y+1);
       writeln('\');
       prtree(temp^.right,(x+d div k),y+3,k);
      end;
  end;


  Procedure prtree1(var temp:tuk;x,y,k:integer);
  var i:integer;
    begin
     inc(k,2);
     gotoxy(x,y);
     write(temp^.key);
     if temp^.left<>nil then begin
       gotoxy(x-1,y+1);
       writeln('/');
       prtree1(temp^.left,(x-d div k),y+3,k)
      end
      else begin
        gotoXY(x-3,y);
        for i:=1 to a[0] do
          if a[i]=temp^.key then break;
        if i=1 then i:=2;
        write(a[i-1],'-');
      end;
     if temp^.right<>nil then begin
       gotoxy(x+1,y+1);
       writeln('\');
       prtree1(temp^.right,(x+d div k),y+3,k);
      end
      else begin
        for i:=1 to a[0] do
          if a[i]=temp^.key then break;
        if i=a[0] then i:=0;
        gotoXY(x+2,y);
        write('-',a[i+1]);
      end;
  end;
 {obhod dereva}
 Procedure obhod(var temp:tuk);
 var subs: string;
  begin
   if temp <> nil then begin
     str(temp^.key, subs);
     s1:=s1+'('+subs+')'+' ';
     s2:=s2+subs+' ';
     s3:=s3+subs+' ';
     a[0]:=a[0]+1;
     a[a[0]]:=temp^.key;
     obhod(temp^.left);
     s1:=s1+subs+' ';
     s2:=s2+'('+subs+')'+' ';
     s3:=s3+subs+' ';
     obhod(temp^.right);
     s1:=s1+subs+' ';
     s2:=s2+subs+' ';
     s3:=s3+'('+subs+')'+' ';
   end
   else begin
     s1:=s1+'0 ';
     s2:=s2+'0 ';
     s3:=s3+'0 ';
   end;
  end;
 {osvobojdenie pamiati, vydelennoi pod dinamicheskie struktury}
 Procedure dtree(var temp:tuk);
  begin
    while temp^.left<>nil do
     dtree(temp^.left);
    if temp^.right<>nil then
     dtree(temp^.right);
    dispose(temp); temp:=nil;
  end;
Begin
  clrscr;
  writeln;
{sozdanie binarnogo dereva}
  root:=nil;
  i:=1;
  kol:=0;
  f:=true;
  while (i<>-100) and f do begin
    Write(' Введите ключ-число (конец ввода -100):  ');
    readln(i);
    if i<>-100 then  addtree(root,i);
  end;
{derevo sozdano,
esli ne bylo dublei kluchei i derevo ne pustoe}
  if f and (root<>nil) then begin
    clrscr;
    s1:=''; s2:=''; s3:='';
    temp:=root;
    k:=0;
    prtree(temp,x,y,0); {vyvod na ekran dereva}
    readln;
    clrscr;
    x:=20; y:=5;
    gotoxy(x,y);
    obhod(root);
    Writeln('Обходы дерева: ');
    writeln;
    writeln('  RAB: ',s1);
    writeln('  ARB: ',s2);
    writeln('  ABR: ',s3);
    obhod(root);  {odin iz sposobov obhoda dereva}
    readkey;
    clrscr;
    prtree1(root,35,2,0);
    dtree(root);  {osvobojdenie pamiati}
   end
   else
    if root<>nil then dtree(root); {osvobojdenie pamiati v sluchae dublia}
  readln;
 end.
