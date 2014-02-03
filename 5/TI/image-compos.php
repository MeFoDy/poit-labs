<? session_start();
// Задаем входные данные ############################################

// Массив $DATA["x"] содержит подписи по оси "X"

$mas1 = $_SESSION[one][compos];
$bool = $_SESSION[two_compos];
if ($bool)
	$mas2 = $_SESSION[two][compos];
$DATA=Array();
for ($i=0;$i<count($mas1);$i++) {
    $DATA[0][$i]=$mas1[$i][percent];
	if ($bool)
		$DATA[1][]=$mas2[$i][percent];
    $DATA["x"][$i]=$mas1[$i][elem];
    }
// Функция вывода псевдо-трехмерного куба ###########################

// $im - идентификатор изображения
// $x,$y - координаты верхнего левого угла куба
// $w - ширина куба
// $h - высота куба
// $dx - смещение задней грани куба по оси X
// $dy - смещение задней грани куба по оси Y
// $c1,$c2,c3 - цвета видимых граней куба

function imagebar($im,$x,$y,$w,$h,$dx,$dy,$c1,$c2,$c3) {

    if ($dx>0) {
        imagefilledpolygon($im,
            Array(
                $x, $y-$h,
                $x+$w, $y-$h,
                $x+$w+$dx, $y-$h-$dy,
                $x+$dx, $y-$dy-$h
            ), 4, $c1);
    
        imagefilledpolygon($im,
            Array(
                $x+$w, $y-$h,
                $x+$w, $y,
                $x+$w+$dx, $y-$dy,
                $x+$w+$dx, $y-$dy-$h
            ), 4, $c3);
        }

    imagefilledrectangle($im, $x, $y-$h, $x+$w, $y, $c2);
    }

// Задаем изменяемые значения #######################################

// Размер изображения
$W=5000;
$H=300;

// Псевдо-глубина графика

$DX=$bool ? 10 : 5;
$DY=$bool ? 15 : 5;
//$DX = 0;
//$DY = 0;
// Отступы
$MB=20; // Нижний
$ML=20; // Левый 
$M=5;   // Верхний и правый отступы. Они меньше, так как там нет текста

// Ширина одного символа
$LW=imagefontwidth(2);

// Подсчитаем количество элементов (столбиков) на графике
$count=count($DATA[0]);
if (count($DATA[1])>$count) $count=count($DATA[1]);

// Подсчитаем максимальное значение
$max=0;
for ($i=0;$i<$count;$i++) {
    $max=$max<$DATA[0][$i]?$DATA[0][$i]:$max;
    $max=$max<$DATA[1][$i]?$DATA[1][$i]:$max;
    }

// Увеличим максимальное значение на 10% (для того, чтобы столбик
// соответствующий максимальному значение не упирался в в границу
// графика
$max=floatval($max+($max/10))+0.001;

// Работа с изображением ############################################

// Создадим изображения
$im=imagecreate($W,$H);

// Задаем основные цвета 

// Цвет фона (белый)
$bg[0]=imagecolorallocate($im,255,255,255);

// Цвет задней грани графика (светло-серый)
$bg[1]=imagecolorallocate($im,231,231,231);

// Цвет левой грани графика (серый)
$bg[2]=imagecolorallocate($im,212,212,212);

// Цвет сетки (серый, темнее)
$c=imagecolorallocate($im,184,184,184);

// Цвет текста (темно-серый)
$text=imagecolorallocate($im,136,136,136);

// Цвета для столбиков
$bar[0][0]=imagecolorallocate($im,240,240,0);
$bar[0][1]=imagecolorallocate($im,220,220,40);
$bar[0][2]=imagecolorallocate($im,180,175,0);
$bar[1][0]=imagecolorallocate($im,128,234,255);
$bar[1][1]=imagecolorallocate($im,95,201,222);
$bar[1][2]=imagecolorallocate($im,65,170,191);

// Количество подписей и горизонтальных линий
// сетки по оси Y.
$county=10;

// Подравняем левую границу с учетом ширины подписей по оси Y
$text_width=strlen($max)*$LW;
$ML+=$text_width;

// Вывод фона графика
imageline($im, $ML, $M+$DY, $ML, $H-$MB, $c);
imageline($im, $ML, $M+$DY, $ML+$DX, $M, $c);
imageline($im, $ML, $H-$MB, $ML+$DX, $H-$MB-$DY, $c);
imageline($im, $ML, $H-$MB, $W-$M-$DX, $H-$MB, $c);
imageline($im, $W-$M-$DX, $H-$MB, $W-$M, $H-$MB-$DY, $c);

imagefilledrectangle($im, $ML+$DX, $M, $W-$M, $H-$MB-$DY, $bg[1]);
imagerectangle($im, $ML+$DX, $M, $W-$M, $H-$MB-$DY, $c);

imagefill($im, $ML+1, $H/2, $bg[2]);

// Количество разных графиков
$s = $bool ? 2 : 1;

// Вывод неизменяемой сетки (горизонтальные линии на
// нижней грани и вертикальные линии сетки на левой
// грани
for ($i=1;$i<$s;$i++) {
    imageline($im, $ML+$i*intval($DX/$s),
                   $M+$DY-$i*intval($DY/$s),
                   $ML+$i*intval($DX/$s),
                   $H-$MB-$i*intval($DY/$s),
                   $c);
    imageline($im, $ML+$i*intval($DX/$s),
                   $H-$MB-$i*intval($DY/$s),
                   $W-$M-$DX+$i*intval($DX/$s),
                   $H-$MB-$i*intval($DY/$s),
                   $c);
    }

// Пересчитаем размеры графика с учетом подписей и отступов
$RW=$W-$ML-$M-$DX;
$RH=$H-$MB-$M-$DY;
$tab = $bool ? $RW/$count/2 : $RW/$count;

// Координаты нулевой точки графика
$X0=$ML+$DX;
$Y0=$H-$MB-$DY;

// Вывод изменяемой сетки (вертикальные линии сетки на нижней грани графика
// и вертикальные линии на задней грани графика)
for ($i=0;$i<$count;$i++) {
    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count)-$DX,$Y0+$DY,$c);
    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count),$Y0-$RH,$c);
    }

// Горизонтальные линии сетки задней и левой граней.
$step=$RH/$county;
for ($i=0;$i<=$county;$i++) {
    imageline($im,$X0,$Y0-$step*$i,$X0+$RW,$Y0-$step*$i,$c);
    imageline($im,$X0,$Y0-$step*$i,$X0-$DX,$Y0-$step*$i+$DY,$c);
    imageline($im,$X0-$DX,$Y0-$step*$i+$DY,
                  $X0-$DX-($ML-$text_width)/4,$Y0-$step*$i+$DY,$text);
    }
	
// Вывод кубов для всех рядов
for ($i=0;$i<$count;$i++) 
    imagebar($im, $X0+$i*($RW/$count)+4-1*intval($DX/$s),
                  $Y0+1*intval($DY/$s),
                  intval($RW/$count)-4,
                  $RH/$max*$DATA[0][$i],
                  intval($DX/$s),
                  intval($DY/$s),
                  $bar[0][0], $bar[0][1], $bar[0][2]);
if ($bool) {
	for ($i=0;$i<$count;$i++) 
		imagebar($im, $X0+$i*($RW/$count)-2*intval($DX/$s)+$tab,
					  $Y0+2*intval($DY/$s),
					  intval($RW/$count)-4-$tab,
					  $RH/$max*$DATA[1][$i],
					  intval($DX/$s),
					  intval($DY/$s),
					  $bar[1][0], $bar[1][1], $bar[1][2]);
}

// Вывод подписей по оси Y
for ($i=1;$i<=$county;$i++) {
    $str=floatval(($max/$county)*$i);
	$str=substr($str, 0, 4);
    imagestring($im,2, $X0-$DX-strlen($str)*$LW-$ML/4-2,
                       $Y0+$DY-$step*$i-imagefontheight(2)/2,
                       $str,$text);
    }

// Вывод подписей по оси X
$prev=100000;
$twidth=$LW*strlen($DATA["x"][0])+6;
$i=$X0+$RW-$DX;

while ($i>$X0-$DX) {
    if ($prev-$twidth>$i) {
        $drawx=$i+1-($RW/$count)/2;
        if ($drawx>$X0-$DX) {
            $str=$DATA["x"][round(($i-$X0+$DX)/($RW/$count))-1];
            imageline($im,$drawx,$Y0+$DY,$i+1-($RW/$count)/2,$Y0+$DY+5,$text);
            imagestring($im,2, $drawx+1-(strlen($str)*$LW)/2 ,$Y0+$DY+7,$str,$text);
            }
        $prev=$i;
        }
    $i-=$RW/$count;
    }

header("Content-Type: image/png");

// Генерация изображения
ImagePNG($im)

//imagedestroy($im);
?>