<?
session_start();

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

//=============================== CLASS_MATRIX
class polynom {
	private $method; //вызываемый метод
	private $msg = 'Решение найдено успешно';
	private $color = "green";
	private $x, $y; //введенные значения
	private $n; //размерность
	private $xIsk; //искомое Х
	private $yIsk; //решение
	private $coeff = array();
	private $graph_x = array(), $graph_y = array(); //данные для графика
		
	function __construct() {
		$this->method = $_POST['method'];
		if (method_exists("polynom", $this->method)) {
			$this->prepare();
			$method = $this->method;
			$this->$method();
		}
		else {
			echo "<p class='red'>Некорректное задание метода</p>";
		}
	}
	
	// подготовка данных
	private function prepare() {
		$this->n = intval($_POST['n-mer']);
		for ($i=0; $i<$this->n; $i++) {
			$this->x[$i] = floatval($_POST['x'][$i]);
			$this->y[$i] = floatval($_POST['y'][$i]);
		}
		$this->xIsk = floatval($_POST['x-isk']);
	}
	
	// метод Лагранжа
	private function method_lagrang() {
		define("XISK", $this->xIsk);
		$this->yIsk = $this->lagr();
		$this->genLagrGraph();
		?>
		<h1>Решение: y(<?=$this->xIsk?>) = <?=$this->yIsk;?></h1>
		<img src="image-graph.php?<?=rand();?>">
		<?		
		$this->msg .= ". Метод Лагранжа";
	}
	
	// произведение внутри многочлена Лагранжа
	private function lagr_proizv($i, $x) {
		$chisl = $znam = 1.0;
		//находим числитель и знаменатель
		for ($k = 0; $k != $this->n; $k++) {
			if ($k == $i) 
				continue;
			$chisl *= $x - $this->x[$k];
			$znam *= $this->x[$i] - $this->x[$k];
		}
		
		return ($chisl / $znam);
	}
	
	// значение многочлена Лагранжа
	private function lagr($x = XISK) {
		$res = 0;
		for ($i = 0; $i<$this->n; $i++) {
			$res += $this->y[$i] * $this->lagr_proizv($i,$x);
		}
		return $res;
	}
	
	// метод Ньютона
	private function method_newton() {
		define("XISK", $this->xIsk);
		$this->yIsk = $this->newton();
		$this->genNewtonGraph();
		?>
		<h1>Решение: y(<?=$this->xIsk?>) = <?=$this->yIsk;?></h1>
		<img src="image-graph.php?<?=rand();?>">
		<?
		$this->msg .= ". Метод Ньютона";
	}
	
	// расчет дельта У
	private function deltaY($n, $deep) {
		if ($deep == 1)
			return ($this->y[$n+1] - $this->y[$n]);
		else {
			return ($this->deltaY($n+1, $deep-1) - $this->deltaY($n, $deep-1));
		}
	}
	
	// значение многочлена Ньютона
	private function newton_old($x = XISK) {
		for ($i=1, $Pn = $this->y[0], $deltaX = 1.0; $i<$this->n; $i++) {
			$deltaX *= $x - $this->x[$i-1];
			for ($j = 0, $sum = 0; $j <= $i; $j++) {
				for ($k=0, $chisl = 1.0; $k<=$i; $k++) {
					if ($k != $j)
						$chisl *= $this->x[$j] - $this->x[$k];
				}
				$sum += $this->y[$j] / $chisl;
			}
			$Pn += $deltaX * $sum;
		}
		return $Pn;
	}
	
	// значение многочлена Ньютона
	private function newton($x = XISK) {
		$Pn = $this->y[0];
		$h = $this->x[1] - $this->x[0];
		$curH = $h;
		$curX = ($x - $this->x[0]);
		$curFact = 1;
		
		for ($i=1; $i<$this->n; $i++) {
			$Pn += $this->deltaY(0, $i) * $curX / $curFact / $curH;
			$curX *= ($x - $this->x[$i]);
			$curFact *= $i+1;
			$curH *= $h;
		}
		//echo $x," ",$Pn, "<br>";
		return $Pn;
	}
	
	// расчет значений для графиков Lagran
	private function genLagrGraph() {
		for ($x = $this->x[0]; $x <= $this->x[$this->n - 1]; $x = $x + 0.05) {
			$x = round($x,2);
			array_push($this->graph_x, $x);
			// вносим данные пользователя
			if (($k = array_search($x, $this->x)) !== FALSE) {
				array_push($this->graph_y, $this->y[$k]);
				continue;
			}
			// рассчитываем промежуточные значения
			array_push($this->graph_y, $this->lagr($x));
		}
		$_SESSION['graph_x'] = $this->graph_x;
		$_SESSION['graph_y'] = $this->graph_y;
	}
	
	// расчет значений для графиков Newton
	private function genNewtonGraph() {
		for ($x = $this->x[0]; $x <= $this->x[$this->n - 1]; $x = $x + 0.05) {
			$x = round($x,2);
			array_push($this->graph_x, $x);
			// вносим данные пользователя
			if (($k = array_search($x, $this->x)) !== FALSE) {
				array_push($this->graph_y, $this->y[$k]);
				continue;
			}
			// рассчитываем промежуточные значения
			array_push($this->graph_y, $this->newton($x));
		}
		$_SESSION['graph_x'] = $this->graph_x;
		$_SESSION['graph_y'] = $this->graph_y;
	}
	
	// расчет значений для графиков сплайнов
	private function genSplineGraph() {
		for ($x = $this->x[0]; $x <= $this->x[$this->n - 1]; $x = $x + 0.05) {
			$x = round($x,2);
			array_push($this->graph_x, $x);
			// вносим данные пользователя
			if (($k = array_search($x, $this->x)) !== FALSE) {
				array_push($this->graph_y, $this->y[$k]);
				continue;
			}
			// рассчитываем промежуточные значения
			array_push($this->graph_y, $this->spline($x));
		}
		$_SESSION['graph_x'] = $this->graph_x;
		$_SESSION['graph_y'] = $this->graph_y;
	}
	
	// метод кубических сплайнов
	private function method_spline() {
		$this->splineCoeff();
		$this->yIsk = $this->spline($this->xIsk);
		$this->genSplineGraph();
		?>
		<h1>Решение: y(<?=$this->xIsk?>) = <?=$this->yIsk;?></h1>
		<img src="image-graph.php?<?=rand();?>">
		<?
		$this->msg .= ". Метод сплайнов";
	}
	
	// расчет коэффициентов для сплайна
	private function splineCoeff() {
		// prepare
		for ($i=0; $i<$this->n; ++$i) {
			$this->coeff[$i]['a'] = $this->y[$i];
			$this->coeff[$i]['x'] = $this->x[$i];
		}
		$this->coeff[0]['c'] = $this->coeff[$this->n - 1]['c'] = 0.0;
		// reshenie
		$alpha = $beta = array();
		$alpha[0] = $beta[0] = 0.0;
		for ($i=1; $i<$this->n-1; ++$i) {
			$hI = $this->x[$i] - $this->x[$i-1];
			$hI1 = $this->x[$i+1] - $this->x[$i];
			$a = $hI;
			$c = 2.0 * ($hI + $hI1);
			$b = $hI1;
			$f = 6.0 * (($this->y[$i+1] - $this->y[$i]) / $hI1 
			- ($this->y[$i] - $this->y[$i-1]) / $hI);
			$z = ($a * $alpha[$i-1] + $c);
			$alpha[$i] = - $b / $z;
			$beta[$i] = ($f - $a * $beta[$i-1]) / $z;
		}
		// ищем С
		for ($i=$this->n-2; $i>0; --$i) {
			$this->coeff[$i]['c'] = $alpha[$i] * $this->coeff[$i+1]['c'] + $beta[$i];
		}
		// ищем b, d
		for ($i=$this->n-1; $i>0; --$i) {
			$hI = $this->x[$i] - $this->x[$i-1];
			$this->coeff[$i]['d'] = ($this->coeff[$i]['c'] - $this->coeff[$i-1]['c']) / $hI;
			$this->coeff[$i]['b'] = $hI * (2.0*$this->coeff[$i]['c'] + $this->coeff[$i-1]['c']) / 6.0 + ($this->y[$i] - $this->y[$i-1]) / $hI;
		}
	}
	
	// построение сплайна
	private function spline($x) {
		$temp = $this->n;
		$this->n = count($this->coeff);
		// бинарный поиск нужного сплайна
		if ($x <= $this->coeff[0]['x'])
			$spline = $this->coeff[1];
		else if (x >= $this->coeff[$this->n - 1]['x'])
			$spline = $this->coeff[$this->n - 1];
		else {			
			$i = 0;
			$j = $this->n - 1;
			while ($i + 1 < $j) {
				$k = $i + ($j-$i)/2;
				if ($x <= $this->coeff[$k]['x'])
					$j = $k;
				else
					$i = $k;
			}
			$spline = $this->coeff[$j];
		}
		
		$deltaX = $x - $spline['x'];
		$res = $spline['a'] + ($spline['b'] + ($spline['c']/2.0 + $spline['d'] * $deltaX / 6.0) * $deltaX) * $deltaX;
		
		$this->n = $temp;
		return $res;
	}
	
	// печать сообщения
	public function printMsg() {
		?>
		<script>$('body').popup("<?=$this->color?>", "<?=$this->msg?>");</script>
		<?	
	}
	
	
}


// ======================================= PAGE

?>
<head>
	<title>ДиВМ №2</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script-2.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №2 по ДиВМ</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых точек</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new polynom();
			?>
			</div>
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="n-mer">Количество заданных точек:</label> <input name="n-mer" id="n-mer" type="number" min="1" value="5"> <input type="button" id="table_but" value="Сгенерировать таблицу" class="button">
		<br><br>
		<label for="method">Выберите метод:</label>
		<select name="method">
			<option value="method_lagrang" selected>1. Лагранжа</option>
			<option value="method_newton">2. Ньютона</option>
			<option value="method_spline">3. Кубических сплайнов</option>
		</select>
		<div id="table" style="display:none"></div>
		<label for="x-isk">Значение Х для искомого узла:</label>
		<input type="text" name="x-isk" required><br>
		<br><input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>