<?
class ImageGraph {
	
	protected $im, $black, $l_grey, $x0, $y0, $maxX, $maxY, $minXVal, $minYVal;
	// ======== отрисовка осей
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
	
	// ======== отрисовка сетки
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
			ImageString($im, 1, 0, ($maxY-$yStep*$i)-3, round($minYVal + $i*$yCoef), $black);
			} 
	}
	
	// ======== отрисовка данных
	function draw_data($x,$y,$rad,$color, $isCore = false)
	{
		global $im,$x0,$y0,$black, $maxX, $maxY;
		
		//рисуем точку
		imagefilledarc($im,$x0 + $x,$maxY-$y,$rad,$rad,0,360,$color,IMG_ARC_PIE);
		if ($isCore) imagearc($im,$x0 + $x,$maxY-$y,$rad,$rad,0,360,$black);
	}
	
	function __construct($pointData, $coresData, $shag) {
		global $im, $black, $l_grey, $x0, $y0, $maxX, $maxY, $minXVal, $minYVal;
		//создаем рисунок 
		$W = 650;
		$H = 400;
		$im = @ImageCreate($W, $H);
		
		// цвета
		$white = ImageColorAllocate ($im, 255, 255, 255);
		$black = ImageColorAllocate ($im, 0, 0, 0);
		$red = ImageColorAllocate ($im, 255, 0, 0);
		$green = ImageColorAllocate ($im, 0, 255, 0);
		$blue = ImageColorAllocate ($im, 0, 0, 255);
		$yellow = ImageColorAllocate ($im, 255, 255, 0);
		$magenta = ImageColorAllocate ($im, 255, 0, 255);
		$cyan = ImageColorAllocate ($im, 0, 255, 255);
		$l_grey = ImageColorAllocate ($im, 200, 200, 200);
		$color = array (
						-1 => imagecolorallocate($im, 100, 100, 100)
						);
		// принцип цикады
		$r = $rn = 71;
		$g = $gn = 31;
		$b = $bn = 97;
		for ($i=0; $i<200; $i++) {
			$color[$i] = imagecolorallocate($im, $r, $g, $b);
			$r += $rn;
			$g += $gn;
			$b += $bn;
		}
	 
		$this->draw_axises($W,$H); //рисуем оси координат
		
		//вычисляем масштаб преобразования данных в координаты рабочей области
		$scaleX=1;
		$scaleY=1;
		//задаем шаг для координатной сетки в пикселах
		$xStep=30;
		$yStep=30;
		//рисуем координатную сетку
		$this->draw_grid($xStep,$yStep, round($xStep/$scaleX,1), round($yStep/$scaleY,1), true);
		
		// ========================================================================================
		
		define("CORE_WEIGHT", 10);
		define("POINT_WEIGHT", 3);
		// рисуем все точки
		for ($i=0; $i<count($pointData); $i++) {
			$point = $pointData[$i];
			$this->draw_data($point['x'], $point['y'], POINT_WEIGHT, $color[$point['class']]);
		}
		// выделяем ядра
		for ($i=0; $i<count($coresData); $i++) {
			$point = $pointData[$coresData[$i]];
			$this->draw_data($point['x'], $point['y'], CORE_WEIGHT, $color[$point['class']], true);
		}
		
		// ========================================================================================
		
		
		imagepng($im,"images/image".$shag.".png"); //выводим рисунок
		imagedestroy($im); //освобождаем занимаемую рисунком память
		
	}
}
