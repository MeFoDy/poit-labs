<?	
	session_start();
	define("LEFT_BORD", 30);
	ini_set('memory_limit', '512M');
	ini_set("max_execution_time", "3600");
//================================ FUNCTIONS
//функция отображения элемента для отладки
function print_otlad($elem) {
	echo "<pre>";
	print_r($elem);
	echo "</pre>";
}

// заполнение пустых ячеек массива mas значением str
function fill_blank_array($mas, $str) {
	foreach ($mas as $key => $value) {
		if (is_blank($value)) {
			$mas[$key] = $str;
		}
	}
	return $mas;
}

//=============================== CLASS_MIAPR
class miapr {
	private $pointCount, $core; // количество точек и классов
	private $color = 'green';
	private $msg = 'Решение задачи прошло успешно';
	private $points = array();
	private $corePoints = array();
	private $shag = 1; // количество итераций
	private $timer;
	private $coresCount, $kolvo;
	private $x, $y, $c, $w, $d, $classes;
	
	function __construct($kolvo) {
		$this->timer = time();
		$this->kolvo = intval($kolvo);
		$this->coresCount = 2 * $this->kolvo;
		
		$this->x = $_POST['x'];
		$this->y = $_POST['y'];
		
		$this->w = array(0,0,0,0);
		for ($i=0; $i<$this->kolvo; $i++) {
			$this->classes[$i] = 0;
			$this->classes[$i + $this->kolvo] = 1;
		}
		
		$this->potencKlass();
		
		$this->msg .= ", время - ".(time() - $this->timer)." c";
		
		?><br>
		<strong>Тестовое значение:</strong> x = (<?
		echo "<input type=\"number\" name=\"x\" id=\"x\" class='x' style=\"width:40px\" autofocus>";
		echo ", <input type=\"number\" name=\"y\" id=\"y\" class='y' style=\"width:40px\">";
		?>) 
		<input type="button" id="set-point" value="Определить" class="button">
		<script>
		var k = [<? for ($i=0; $i<4; $i++) {
						if ($i<>0) echo ",";						
							echo $this->w[$i];
					} ?>];
		</script>
		<div style="clear:both"></div>
		<?
	}
	
	// метод 
	private function potencKlass() {
		$this->msg = 'Классов - 2';
		
		$flag = true;
		$k = $this->w;
		$ro = 1;
		$atata = 0;
		// пока не выполним итерацию без наказаний
		while ($flag) {
			$flag = false;
			for ($i=0; $i<$this->coresCount; $i++) {
				$curX = array($this->x[$i], $this->y[$i]);
				$nextX = array($this->x[($i+1) % $this->coresCount], $this->y[($i+1) % $this->coresCount]);
				$tempK = $this->getK($curX);
				for ($j=0; $j<4; $j++) {
					$k[$j] += $ro * $tempK[$j];
				}
				
				$sum = 0;
				$sum += $k[0];
				$sum += $k[1] * $nextX[0];
				$sum += $k[2] * $nextX[1];
				$sum += $k[3] * $nextX[0] * $nextX[1];
				
				if ($sum > 0 && $this->classes[($i+1) % $this->coresCount]) {
					$ro = -1;
					$flag = true;
				}
				elseif ($sum <= 0 && !$this->classes[($i+1) % $this->coresCount]) {
					$ro = 1;
					$flag = true;
				}
				else 
					$ro = 0;
			}
			$this->w = $k;
			$atata++;
			if ($atata > 10000) {
				$this->color = 'red';
				$this->msg = 'Функция расходится';
				break;
			}
		}
		
		$this->Otris();
		$this->printResh();
	}
	
	// расчет значения K(x, xi);
	private function getK($xi) {
		return array(1, 4*$xi[0], 4*$xi[1], 16*$xi[0]*$xi[1]);
	}
	
	// печать решающих функций
	private function printResh() {
		?>
		<h4>Исходные данные:</h4><br>
		<?
		$n = $this->kolvo;	
		echo "<b>Класс 1</b><table style='font-size:12px;'>";
		for ($i=0; $i<$n; $i++) {
			echo "<tr>";
			echo "<td>";
			echo "x<sub>1," , ($i+1) , "</sub> = (", $this->x[$i] , ", " , $this->y[$i] , ")";
			echo "</td></tr>";
		}
		echo "</table>";
		
		echo "<b>Класс 2</b><table style='font-size:12px;'>";
		for ($i=0; $i<$n; $i++) {
			echo "<tr>";
			echo "<td>";
			echo "x<sub>2," , ($i+1) , "</sub> = (", $this->x[$i + $this->kolvo] , ", " , $this->y[$i + $this->kolvo] , ")";
			echo "</td></tr>";
		}
		echo "</table>";
		
		$k = $this->w;
		?>
		<h4>Решающая функция:</h4>
		<img src="image-graph-5.php" align="right"><p>
		<big>d(x) = <?=$this->printCh($k[0], true)?><?=$this->printCh($k[1])?>x<sub>1</sub><?=$this->printCh($k[2])?>x<sub>2</sub><?=$this->printCh($k[3])?>x<sub>1</sub>x<sub>2</sub>, отсюда</big>
		<big></p>x<sub>2</sub> = (<?=$this->printCh(-$k[1], true)?>x<sub>1</sub><?=$this->printCh(-$k[0])?>)/(<?=$this->printCh($k[3],true)?>x<sub>1</sub><?=$this->printCh($k[2])?>)</big>		
		<?
	}
	
	private function printCh($x, $first = false) {
		$str = '';
		if ($x < 0)
			$str .= " - ";
		elseif ($x >= 0) {
			if (!$first) 
				$str .= " + ";
		}
		$str .= abs($x);
		return $str;
	}
		
	// расстояние между двумя точками
	private function EvklRast($x1, $y1, $x2, $y2) {
		return /*sqrt*/(($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2));
	}
	
	private function Otris() {
		$x = $this->x;
		$y = $this->y;
		$k = $this->w;
		$shag = 0;
		$bord = max(max(max($x),max($y)),abs(min(min($x), min($y)))) + 1;
		$_SESSION['bord'] = $bord;
		$strX = 'graph_x';
		$strY = 'graph_y';
		if ($k[3]) {
			$o = -$k[2] / $k[3];
		}
		else
			$o = 0;
		// график
		for ($i=-LEFT_BORD; $i<$o; $i+=0.1) {
			if (abs($k[3]*$i + $k[2]) > 0.00001) {
				$j = (-$k[1]*$i -$k[0])/($k[3]*$i + $k[2]);	
				$_SESSION[$strX][$shag] = $i;
				$_SESSION[$strY][$shag++] = $j;
			}
		}
		$shag = 0;
		$strX = 'graph_x1';
		$strY = 'graph_y1';
		for ($i=$o; $i<LEFT_BORD; $i+=0.1) {
			if (abs($k[3]*$i + $k[2]) > 0.00001) {
				$j = (-$k[1]*$i -$k[0])/($k[3]*$i + $k[2]);	
				$_SESSION[$strX][$shag] = $i;
				$_SESSION[$strY][$shag++] = $j;
			}
		}
		// ядра
		for ($i=0; $i<$this->kolvo; $i++) {
			$_SESSION['core'][$i]['x'] = $this->x[$i];
			$_SESSION['core'][$i]['y'] = $this->y[$i];
			$_SESSION['core'][$i]['class'] = 0;
			$_SESSION['core'][$i+$this->kolvo]['x'] = $this->x[$i+$this->kolvo];
			$_SESSION['core'][$i+$this->kolvo]['y'] = $this->y[$i+$this->kolvo];
			$_SESSION['core'][$i+$this->kolvo]['class'] = 1;
		}
		/*
		$sum = 0;
				$sum += $k[0];
				$sum += $k[1] * $i;
				$sum += $k[2] * $j;
				$sum += $k[3] * $i * $j;
		*/
	}
	
	// печать сообщения о решении
	public function printMsg() {
		?>
		<script>$('body').popup("<?=$this->color?>", "<?=$this->msg?>");</script>
		<?	
	}
	
}


// ======================================= PAGE

?>
<meta http-equiv="Pragma" content="no-cache">
<head>
	<title>МиАПР №5</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="jquery.lightbox.js"></script>
	<script src="script-5.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №5 по МиАПР</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых классов</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new miapr($_POST['kolvo']);
			?>
			</div>
			<!--<input type="button" id="next-img" value="Следующее" class="button" style="position:fixed; bottom:15px; right:35px; z-index:1000;"> -->
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="core">Количество объектов в классе: </label>
		<input type="number" min="1" name="kolvo" value="2" id="kolvo"><br><br>
		<label for="table">Обучающая выборка: </label><br>
		<div id="table"></div>
		<input type="button" id="table_but" value="Сгенерировать матрицу" class="button"> <input type="button" id="gener_but" value="Заполнить случайными числами" class="button"><br>
		<br><br>
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>