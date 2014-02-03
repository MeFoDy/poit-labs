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
function draw_border($xStep, $yStep, $xCoef, $yCoef) {
	global $im,$black,$l_grey,$x0,$y0,$maxX,$maxY, $minYVal, $minXVal;
	$xSteps=($maxX-$x0)/$xStep-1; //определяем количество шагов по оси X
	$ySteps=($maxY-$y0)/$yStep-1; //определяем количество шагов по оси Y
	
	$i=$xSteps+1;
		imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i, $maxY-1, $l_grey);
	
	$i=$ySteps+1;
		imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $l_grey);
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
		ImageString($im, 1, ($x0+$xStep*$i)-1, $maxY+2, round($minXVal + $i*$xCoef, 2), $black);
 
		}
	for($i=1;$i<$ySteps+2;$i++)
		{
		imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $l_grey);
		//при необходимости выводим значения линий сетки по оси Y
		ImageString($im, 1, 0, ($maxY-$yStep*$i)-3, round($minYVal + $i*$yCoef, 4), $black);
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
	//создаем рисунок шириной 500 и высотой 400 пикселов
	$W = 650;
	$H = 400;
	$im = @ImageCreate($W, $H);
	$white = imagecolorallocatealpha($im, 255, 255, 255, 80);
	$black = ImageColorAllocate ($im, 0, 0, 0);
	$red = imagecolorallocatealpha($im, 255, 0, 0, 80);
	$green = ImageColorAllocate ($im, 0, 255, 0);
	$blue = imagecolorallocatealpha($im, 0, 0, 255, 80);
	$yellow = ImageColorAllocate ($im, 255, 255, 0);
	$magenta = ImageColorAllocate ($im, 255, 0, 255);
	$cyan = ImageColorAllocate ($im, 0, 255, 255);
	$l_grey = imagecolorallocatealpha($im, 200, 200, 200, 80);
 
	draw_axises($W,$H); //рисуем оси координат
	
	//заносим данные из сессии в массив
	$x=$_SESSION['graph_x'];
	$y=$_SESSION['graph_y'];
	$x1 = $x;
	$y1 = $y;
	if ($_SESSION['graph_x1']) {
		$x1 = $_SESSION['graph_x1'];
		$y1	= $_SESSION['graph_y1'];
	}
	
	/*
	$x = array(1,2,3,4,5);
	$y = array(3,5,4,6,2);
	$x1 = $x;
	$y1 = array(1,8,3,2,7);
	/*
	*/
	if (count($x) == 0)
	{
		draw_grid(20,20, 1, 1, true);
		ImagePNG($im); //выводим рисунок
		imagedestroy($im); //освобождаем занимаемую рисунком память
		exit;
	}
	//получаем максимальные значения элементов для каждого массива
	$maxXVal=max(max($x),max($x1));
	$maxYVal=max(max($y),max($y1));
	$minXVal=min(min($x),min($x1));
	$minYVal=min(min($y),min($y1));
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
	draw_border($xStep,$yStep, round($xStep/$scaleX,3), round($yStep/$scaleY,5));
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
	for ($i=0; $i<count($x1); $i++) {
		$x1[$i] -= $minXVal;
		$y1[$i] -= $minYVal;
	}
	draw_data($x1,$y1,count($x1),$blue); //рисуем второй график
	imagefill($im, $x0+$x1[500]*$scaleX+1, $maxY-1, $l_grey);
	
	//рисуем координатную сетку
	draw_grid($xStep,$yStep, round($xStep/$scaleX,3), round($yStep/$scaleY,5));
	
	
	ImagePNG($im); //выводим рисунок
	imagedestroy($im); //освобождаем занимаемую рисунком память
	unset($_SESSION[graph_x], $_SESSION[graph_y], $_SESSION[graph_x1], $_SESSION[graph_y1]);
?>