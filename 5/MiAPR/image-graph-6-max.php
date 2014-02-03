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
		//ImageString($im, 1, ($x0+$xStep*$i)-1, $maxY+2, round($minXVal + $i*$xCoef), $black);
 
		}
	for($i=1;$i<$ySteps+2;$i++)
		{
		imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $l_grey);
		//при необходимости выводим значения линий сетки по оси Y
		//ImageString($im, 1, 0, ($maxY-$yStep*$i)-3, round($minYVal + $i*$yCoef,2), $black);
		} 
}
function draw_data($tree)
{
	global $im,$x0,$y0,$maxY,$scaleX,$scaleY, $color, $black;
	//imageline($im, $x0+$data_x[$i-1]*$scaleX, $maxY-$data_y[$i-1]*$scaleY, $x0+$data_x[$i]*$scaleX, $maxY-$data_y[$i]*$scaleY, $color);
	if (is_array($tree)) {
		draw_data($tree[0]);
		draw_data($tree[1]);
	}
	imageline($im, $x0+$tree['x0']*$scaleX, $maxY-$tree['y']*$scaleY, $x0+$tree['x1']*$scaleX, $maxY-$tree['y']*$scaleY, $color);
	imageline($im, $x0+$tree['x0']*$scaleX, $maxY-$tree['y']*$scaleY, $x0+$tree['x0']*$scaleX, $maxY-$tree[0]['y']*$scaleY, $color);
	imageline($im, $x0+$tree['x1']*$scaleX, $maxY-$tree['y']*$scaleY, $x0+$tree['x1']*$scaleX, $maxY-$tree[1]['y']*$scaleY, $color);
	
}

function draw_subdata($tree)
{
	global $im,$x0,$y0,$maxY,$scaleX,$scaleY, $color, $black;
	//imageline($im, $x0+$data_x[$i-1]*$scaleX, $maxY-$data_y[$i-1]*$scaleY, $x0+$data_x[$i]*$scaleX, $maxY-$data_y[$i]*$scaleY, $color);
	if (is_array($tree[0])) {
		draw_subdata($tree[0]);
	}
	if (is_array($tree[1])) {
		draw_subdata($tree[1]);
	}
	if (!is_array($tree[0])) {
		imagestring($im, 2, $x0+$tree['x0']*$scaleX-3, $maxY+2, 'x'.($tree[0]+1), $black);
	}
	if (!is_array($tree[1])) {
		imagestring($im, 2, $x0+$tree['x1']*$scaleX-3, $maxY+2, 'x'.($tree[1]+1), $black);
	}
	
	imageline($im, $x0+$tree['x0']*$scaleX, $maxY-$tree['y']*$scaleY, $x0, $maxY-$tree['y']*$scaleY, $color);
	
	imagestring($im,2, 5, ($maxY-$tree['y']*$scaleY)-8, round(100 - $tree['y'],2), $black);
}

function draw_core($tree)
	{
		global $im,$x0,$y0,$black, $maxX, $maxY, $scaleX, $scaleY, $color;
		$rad = 5;
		//рисуем точку
		if (!is_array($tree[0])) {
		}
		else
			draw_core($tree[0]);
			
		$x = ($tree['x0'] + $tree['x1']) / 2;
		imagefilledarc($im, $x0+$x*$scaleX, $maxY-$tree['y']*$scaleY,$rad,$rad,0,360,$color, IMG_ARC_PIE);
		//imagestring($im,2, $x0+$x*$scaleX, $maxY-$tree['y']*$scaleY+5, round($tree['min'],2), $black);
		
		if (!is_array($tree[1])) {
			
		}
		else
			draw_core($tree[1]);
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
	$tree = $_SESSION['mas1'];
	if (count($tree) == 0)
	{
		draw_grid(20,20, 1, 1, true);
		ImagePNG($im); //выводим рисунок
		imagedestroy($im); //освобождаем занимаемую рисунком память
		exit;
	}
	
	//получаем максимальные значения элементов для каждого массива
	$maxXVal = $_SESSION['max1'];
	$maxYVal = $_SESSION['maxmax'];
	
	$minXVal=0;
	$minYVal=0;
	
	//вычисляем масштаб преобразования данных в координаты рабочей области
	$scaleX=($maxX-$x0)/($maxXVal-$minXVal);
	$scaleY=($maxY-$y0)/($maxYVal-$minYVal);
	//задаем шаг для координатной сетки в пикселах
	$xStep=30;
	$yStep=30;
	//рисуем координатную сетку
	//draw_grid($xStep,$yStep, round($xStep/$scaleX,3), round($yStep/$scaleY,5), true);

	$color = $l_grey;
	draw_subdata($tree);
	
	imagesetthickness($im,2);
	$color = $red;
	draw_data($tree); 
	
	$color = $blue;
	draw_core($tree);
	
	ImagePNG($im); //выводим рисунок
	imagedestroy($im); //освобождаем занимаемую рисунком память
	unset($_SESSION['mas1']);
?>