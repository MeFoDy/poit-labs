<?php
session_start();
header("Content-type: image/png");
function draw_axises($im_width,$im_heignt)
{
	global $im, $black, $l_grey, $x0, $y0, $maxX, $maxY, $minXVal, $minYVal;
	
	$x0=25.0; //начало оси координат по X
	$y0=20.0; //начало оси координат по Y
	
	$maxX=$im_width-$x0;  //максимальное значение оси координат по X в пикселах
	$maxY=$im_heignt-$y0; //максимальное значение оси координат по Y в пикселах
	imageline($im, $x0, $maxY, $maxX+5, $maxY, $black); //рисуем ось X
	imageline($im, $x0, $y0-5, $x0, $maxY, $black);     //рисуем ось Y
 
	//рисуем стрелку на оси X
	$xArrow[0]=$maxX+2; $xArrow[1]=$maxY-2;
	$xArrow[2]=$maxX+8; $xArrow[3]=$maxY;
	$xArrow[4]=$maxX+2; $xArrow[5]=$maxY+2;
	imagefilledpolygon($im, $xArrow, 3, $black);
	//рисуем стрелку на оси Y
	$yArrow[0]=$x0-2; $yArrow[1]=$y0-2;
	$yArrow[2]=$x0; $yArrow[3]=$y0-8;
	$yArrow[4]=$x0+2; $yArrow[5]=$y0-2;
	imagefilledpolygon($im, $yArrow, 3, $black);
}
function draw_grid($xStep,$yStep,$xCoef,$yCoef)
{
	global $im,$black,$l_grey,$x0,$y0,$maxX,$maxY, $minYVal, $minXVal;
	$xSteps=($maxX-$x0)/$xStep-1; //определяем количество шагов по оси X
	$ySteps=($maxY-$y0)/$yStep-1; //определяем количество шагов по оси Y
 
	for($i=1;$i<$xSteps+2;$i++)   //выводим сетку по оси X
		{
		imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i, $maxY-1, $l_grey);
		//при необходимости выводим значения линий сетки по оси X
		ImageString($im, 1, ($x0+$xStep*$i)-1, $maxY+2, round($minXVal + $i*$xCoef), $black);
 
		}
	for($i=1;$i<$ySteps+2;$i++)
		{
		imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $l_grey);
		//при необходимости выводим значения линий сетки по оси Y
		ImageString($im, 1, 0, ($maxY-$yStep*$i)-3, round($minYVal + $i*$yCoef,2), $black);
		} 
}
function draw_data($data_x,$data_y,$points_count,$color)
{
	global $im,$x0,$y0,$maxY,$scaleX,$scaleY;
	for($i=1;$i<$points_count;$i++)
		{
		//рисуем линейный график по точкам из массивов данных
		imageline($im, $x0+$data_x[$i-1]*$scaleX, $maxY-$data_y[$i-1]*$scaleY, $x0+$data_x[$i]*$scaleX, $maxY-$data_y[$i]*$scaleY, $color);
		}
}
function draw_core($xt,$yt,$rad,$color, $isCore = true)
	{
		global $im,$x0,$y0,$black, $maxX, $maxY, $scaleX, $scaleY;
		
		//рисуем точку
		imagefilledarc($im, $x0+$xt*$scaleX, ($maxY-$yt*$scaleY),$rad,$rad,0,360,$color,IMG_ARC_PIE);
		if ($isCore) imagearc($im, $x0+$xt*$scaleX, $maxY-$yt*$scaleY,$rad,$rad,0,360,$black);
	}
	//создаем рисунок шириной 500 и высотой 400 пикселов
	$W = 650;
	$H = 400;
	$im = @ImageCreate($W, $H);
	$white = ImageColorAllocate ($im, 255, 255, 255);
	$black = ImageColorAllocate ($im, 0, 0, 0);
	$red = ImageColorAllocate ($im, 255, 0, 0);
	$green = ImageColorAllocate ($im, 0, 255, 0);
	$blue = ImageColorAllocate ($im, 0, 0, 255);
	$yellow = ImageColorAllocate ($im, 255, 255, 0);
	$magenta = ImageColorAllocate ($im, 255, 0, 255);
	$cyan = ImageColorAllocate ($im, 0, 255, 255);
	$l_grey = ImageColorAllocate ($im, 200, 200, 200);
 
	draw_axises($W,$H); //рисуем оси координат
	
	//заносим данные из сессии в массив
	$x=$_SESSION['graph_x'];
	$y=$_SESSION['graph_y'];
	$cores = $_SESSION['core'];
	$x1 = $x;
	$y1 = $y;
	if ($_SESSION['graph_x1']) {
		$x1 = $_SESSION['graph_x1'];
		$y1	= $_SESSION['graph_y1'];
	}
	if (count($x) == 0)
	{
		draw_grid(20,20, 1, 1, true);
		ImagePNG($im); //выводим рисунок
		imagedestroy($im); //освобождаем занимаемую рисунком память
		exit;
	}
	$bord = $_SESSION['bord'];
	//получаем максимальные значения элементов для каждого массива
	$maxXVal=max(max($x),max($x1));
	$maxYVal=max(max($y),max($y1));
	$maxYVal = $bord;
	$minXVal=min(min($x),min($x1));
	$minYVal=min(min($y),min($y1));
	$minYVal = -$bord;
	if ($maxXVal == $minXVal) {
		$maxXVal += 10;
		$minXVal -= 10;
	}
	if ($maxYVal == $minYVal) {
		$maxYVal += 6;
		$minYVal -= 6;
	}
	//вычисляем масштаб преобразования данных в координаты рабочей области
	$scaleX=($maxX-$x0)/($maxXVal-$minXVal);
	$scaleY=($maxY-$y0)/($maxYVal-$minYVal);
	//задаем шаг для координатной сетки в пикселах
	$xStep=30;
	$yStep=30;
	//рисуем координатную сетку
	draw_grid($xStep,$yStep, round($xStep/$scaleX,3), round($yStep/$scaleY,5), true);
	//отрисовка единственной точки
	if (count($x) == 1) {
		$x[1] = $x[0]-0.01*($maxXVal-$minXVal);		$y[1] = $y[0]-0.01*($maxYVal-$minYVal);
		$x[2] = $x[1];								$y[2] = $y[1]+0.02*($maxYVal-$minYVal);
		$x[3] = $x[2]+0.02*($maxXVal-$minXVal);		$y[3] = $y[2];
		$x[4] = $x[3];								$y[4] = $y[3]-0.02*($maxYVal-$minYVal);
		$x[5] = $x[4]-0.02*($maxXVal-$minXVal);		$y[5] = $y[4];
	}
	for ($i=0; $i<count($x); $i++) {
		$x[$i] -= $minXVal;
		$y[$i] -= $minYVal;
	}
	draw_data($x,$y,count($x),$red); //рисуем первый график
	if (abs($y[count($y)-1] - $y[count($y)-2]) > 0) {
		$sign = ($y[count($y)-1] - $y[count($y)-2]) / abs($y[count($y)-1] - $y[count($y)-2]);
	}
	else 
		$sign = 1;
	imageline($im, $x0+$x[count($x)-1]*$scaleX, $maxY-$y[count($y)-1]*$scaleY, 
			  $x0+$x[count($x)-1]*$scaleX, 
			  $maxY-$maxY*$sign*$scaleY, 
			  $red);
	if ($_SESSION['graph_x1']) {
		if (count($x1) == 1) {
			$x1[1] = $x1[0]-0.01*($maxXVal-$minXVal);		$y1[1] = $y1[0]-0.01*($maxYVal-$minYVal);
			$x1[2] = $x1[1];								$y1[2] = $y1[1]+0.02*($maxYVal-$minYVal);
			$x1[3] = $x1[2]+0.02*($maxXVal-$minXVal);		$y1[3] = $y1[2];
			$x1[4] = $x1[3];								$y1[4] = $y1[3]-0.02*($maxYVal-$minYVal);
			$x1[5] = $x1[4]-0.02*($maxXVal-$minXVal);		$y1[5] = $y1[4];
		}
		for ($i=0; $i<count($x1); $i++) {
			$x1[$i] -= $minXVal;
			$y1[$i] -= $minYVal;
		}
		draw_data($x1,$y1,count($x1)-1,$blue); //рисуем второй график
		$sign *= -1;
		imageline($im, $x0+$x1[0]*$scaleX, $maxY-$y1[0]*$scaleY, 
			  $x0+$x1[0]*$scaleX, 
			  $maxY-$maxY*$sign*$scaleY, 
			  $blue);
	}
	
	for ($i=0; $i<count($cores); $i++) {
		$color = $magenta;
		if ($cores[$i]['class'] == 1)
			$color = $green;
		draw_core($cores[$i]['x'] - $minXVal,$cores[$i]['y']-$minYVal,10,$color);
	}
	
	ImagePNG($im); //выводим рисунок
	imagedestroy($im); //освобождаем занимаемую рисунком память
	unset($_SESSION[graph_x], $_SESSION[graph_y], $_SESSION[graph_x1], $_SESSION[graph_y1], $_SESSION['core'], $_SESSION['bord']);
?>