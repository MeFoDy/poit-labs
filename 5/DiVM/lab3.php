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
class lab3 {
	private $method; //вызываемый метод
	private $msg = 'Решение найдено успешно';
	private $color = "green";
	private $a, $b, $n, $eps; //введенные значения
	private $h; //шаг
	
	private $xIsk; //искомое Х
	private $ansPr1, $ansPr2, $ansIntKvadr, $ansIntSimpson; //решение
	private $masPr1, $masPr2; //массивы решений
	private $coeff = array();
	private $graph_x = array(), $graph_y = array(); //данные для графика
		
	function __construct() {
		$this->method = $_POST['method'];
		if (method_exists("lab3", $this->method)) {
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
		$this->n = intval($_POST['n']);
		$this->a = floatval($_POST['a']);
		$this->b = floatval($_POST['b']);
		$this->eps = floatval($_POST['eps']);
		
		$this->xIsk = ($this->a + $this->b) / 2;
		$this->h = ($this->b - $this->a) / $this->n;
	}
	
	// вычисления
	private function method_lab3() {
		define("XISK", $this->xIsk);
		$this->doPr1();
		$this->ansIntKvadr = $this->doIntKvadr();
		$this->ansIntSimpson = $this->doIntSimpson();
		$this->genGraph();
		?>
		<h1>Решение: </h1>
		<p>y'(<?=$this->xIsk?>) = <?=$this->ansPr1;?></p>
		<input type="button" class="button" value="Промежуточные решения" onClick="$('#pr1').toggle('slow');">
		<pre id="pr1" style="display:none"><strong>Производные для промежуточных сплайнов:</strong>
<?
		for ($i = $this->a, $j = 0; $i<=$this->b; $i = $i + 5*$this->h, $j++) {
			$cur = intval(($i - $this->a) / $this->h + $this->h/2);
			echo "y'(".$i.") = ".$this->masPr1[$cur], "\n";
		}
		?>
		</pre>
		<p>y''(<?=$this->xIsk?>) = <?=$this->ansPr2;?></p>
		<input type="button" class="button" value="Промежуточные решения" onClick="$('#pr2').toggle('slow');">
		<pre id="pr2" style="display:none"><strong>Вторые производные для промежуточных сплайнов:</strong>
<?
		for ($i = $this->a, $j = 0; $i<=$this->b; $i = $i + 5*$this->h, $j++) {
			$cur = intval(($i - $this->a) / $this->h + $this->h/2);
			echo "y''(".$i.") = ".$this->masPr2[$cur], "\n";
		}
		?>
		</pre>
		<p>Квадратурная формула Гаусса: &int;y(x)dx = <?=$this->ansIntKvadr;?></p>
		<p>Метод Симпсона: &int;y(x)dx = <?=$this->ansIntSimpson;?></p>
		<img src="image-graph.php?<?=rand();?>">
		<?		
	}
	
	// нахождение производной от функции sinX
	private function doPr1() {
		//расчет значений функций для каждого сплайна
		for ($i=0; $i<=$this->n; $i++) {
			$a = $this->a + $i*$this->h;
			$y[$i] = sin($a);
		}
		
		$h1 = 2*$this->h;
		$h2 = $this->h * $this->h;
		//расчет производных
		for ($i = $this->a, $j = 0; $i<=$this->b; $i = $i + $this->h, $j++) {
			//левая граничная точка
			$cur = intval(($i - $this->a) / $this->h + $this->h/2);
			if ($cur == 0) {
				$this->masPr1[$j] = (-3 * $y[0] + 4 * $y[1] - $y[2]) / $h1;
				$this->masPr2[$j] = (2 * $y[0] - 5 * $y[1] + 4 * $y[2] - $y[3]) / $h2; 
			}
			//правая граничная точка
			elseif ($cur == $this->n) {
				$this->masPr1[$j] = ($y[$this->n-2] - 4 * $y[$this->n-1] + 3 * $y[$this->n]) / $h1;
				$this->masPr2[$j] = (-$y[$this->n-3] + 4 * $y[$this->n-2] - 5 * $y[$this->n-1] + 2 * $y[$this->n]) / $h2;
			}
			//внутренние точки
			else {
				$this->masPr1[$j] = (-$y[$cur-1] + $y[$cur+1]) / $h1;
				$this->masPr2[$j] = ($y[$cur-1] - 2 * $y[$cur] + $y[$cur+1]) / $h2;
			}
		}
		
		// расчет производных для середины
		$cur = intval(($this->xIsk - $this->a) / $this->h + $this->h/2);
		if ($cur == 0) {
			$this->ansPr1 = (-3 * $y[0] + 4 * $y[1] - $y[2]) / $h1;
			$this->ansPr2 = (2 * $y[0] - 5 * $y[1] + 4 * $y[2] - $y[3]) / $h2; 
		}
		elseif ($cur == $this->n) {
			$this->ansPr1 = ($y[$this->n-2] - 4 * $y[$this->n-1] + 3 * $y[$this->n]) / $h1;
			$this->ansPr2 = (-$y[$this->n-3] + 4 * $y[$this->n-2] - 5 * $y[$this->n-1] + 2 * $y[$this->n]) / $h2;
		}
		else {
			$this->ansPr1 = (-$y[$cur-1] + $y[$cur+1]) / $h1;
			$this->ansPr2 = ($y[$cur-1] - 2 * $y[$cur] + $y[$cur+1]) / $h2;
		}
	}

	
	// нахождение интеграла от функции x/cosX
	private function doIntSimpson() {
		// проверка деления на 0
		if (abs(cos($this->a)) < $this->eps
			|| abs(cos($this->b)) < $this->eps
			|| abs(cos($this->xIsk)) < $this->eps) {
			$this->color = 'red';
			$this->msg = 'Произошло деление на ноль. Вычисление интеграла невозможно';
			return 'NaN';
		}
		//расчет
		$y0 = $this->a / cos($this->a);
		$yN = $this->b / cos($this->b);
		$s = $y0 + $yN;
		$s1 = ($this->b - $this->a) * ($y0 + $yN + 4 * $this->xIsk / cos($this->xIsk)) / 6;
		$n = 2;
		do {
			$h = ($this->b - $this->a) / $n;
			$x1 = $this->a + $h/2;
			$x2 = $this->a + $h;
			$s2 = $s;
			for ($j=0; $j<$n; $j++) {
				if (abs(cos($x1)) < $this->eps
					|| abs(cos($x2)) < $this->eps) {
					$this->color = 'red';
					$this->msg = 'Произошло деление на ноль. Вычисление интеграла прекращено';
					return $s1;
				}
				$s2 += 4 * $x1 / cos($x1) + 2 * $x2 / cos($x2);
				$x1 += $h;
				$x2 += $h;				
			}
			$s2 *= $h/6;
			$d = abs($s1 - $s2);
			$s1 = $s2;
			$n *= 2;
		} while ($d>$this->eps);
		$this->msg .= "<br> Погрешность Симпсона - ".$d;
		return $s1;
	}
	
	// нахождение интеграла от функции x/cosX
	private function doIntKvadr() {
		$c1 = ($this->a + $this->b) / 2;
		$c2 = ($this->b - $this->a) / (2 * sqrt(3));
		$ser = ($this->b - $this->a) / 2;
		// проверка деления на 0
		if (abs(cos($c1 + $c2)) < $this->eps
			|| abs(cos($c1 - $c2)) < $this->eps) {
			$this->color = 'red';
			$this->msg = 'Произошло деление на ноль. Вычисление интеграла невозможно';
			return 'NaN';
		}
		$s0 = $ser * (($c1 - $c2)/cos($c1 - $c2) + ($c1 + $c2)/cos($c1 + $c2));
		$n = 2;
		do {
			$h = ($this->b - $this->a) / $n;
			$s = 0;
			for ($i=0; $i<$n; $i++) {
				$a = $this->a + $i*$h;
				$b = $a + $h;
				$c1 = ($a + $b) / 2;
				$c2 = ($b - $a) / (2 * sqrt(3));
				$ser = ($b - $a) / 2;
				// проверка деления на 0
				if (abs(cos($c1 + $c2)) < $this->eps
					|| abs(cos($c1 - $c2)) < $this->eps) {
					$this->color = 'red';
					$this->msg = 'Произошло деление на ноль. Вычисление интеграла невозможно';
					return $s0;
				}
				$s += $ser * (($c1 - $c2)/cos($c1 - $c2) + ($c1 + $c2)/cos($c1 + $c2));
			}
			$d = abs($s - $s0);
			$s0 = $s;
			$n *= 2;
		} while ($d>$this->eps);
		$this->msg .= "<br> Погрешность Гаусса - ".$d;
		
		return $s0;
	}
	
	// расчет значений для графиков
	private function genGraph() {
		for ($i = $this->a; $i<=$this->b; $i = $i + $this->h) {
			array_push($this->graph_x, $i);
			array_push($this->graph_y, sin($i));
		}
		$_SESSION['graph_x'] = $this->graph_x;
		$_SESSION['graph_y'] = $this->graph_y;
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
	<title>ДиВМ №3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script-3.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №3 по ДиВМ</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых значений</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new lab3();
			?>
			</div>
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="a">Значение А:</label> <input name="a" value="1"><br>
		<label for="b">Значение В:</label> <input name="b" value="3"><br>
		<label for="n">Количество сплайнов:</label> <input name="n" id="n-mer" type="number" min="5" value="1000"><br>
		<label for="eps">Точность вычисления:</label> <input name="eps" value="0.001">
		<br><br>
		<input type="hidden" name="method" value="method_lab3">
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>