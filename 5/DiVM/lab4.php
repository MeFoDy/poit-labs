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
class lab4 {
	private $method; //вызываемый метод
	private $msg = 'Решение найдено успешно';
	private $color = "green";
	private $a, $b, $n, $eps; //введенные значения
	
	private $ansInt; //решение
	private $graph_x = array(), $graph_y = array(); //данные для графика
	private $graph_x1 = array(), $graph_y1 = array(); //данные для графика

		
	function __construct() {
		$this->method = $_POST['method'];
		if (method_exists("lab4", $this->method)) {
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
	}
	
	// вычисления
	private function method_lab4() {
		$this->ansInt = $this->doIntegral();
		$this->genGraph();
		?>
		<h1>Решение: </h1>
		<img src="integral-1.png">
		<p>Метод Монте-Карло: &int;y(x)dx = <?=$this->ansInt;?></p>
		<img src="image-graph.php?<?=rand();?>">
		<?		
	}
	
	
	// нахождение интеграла от функции x/cosX
	private function doIntegral() {
		$a = $this->a;
		$b = $this->b;
		$int = 0;
		for ($i=0; $i<$this->n; $i++) {
			$r = rand() % $b + $a;
			$int += $r*$r*sin($r)*cos($r);
		}
		
		$int /= $this->n;
		
		return $int;
	}
	
	// расчет значений для графиков
	private function genGraph() {
		for ($i = $this->a; $i<=$this->b; $i+=0.01) {
			array_push($this->graph_x, $i);
			array_push($this->graph_y, $i*$i*sin($i)*cos($i));
			array_push($this->graph_x1, $i);
			array_push($this->graph_y1, 0);
		}
		$_SESSION['graph_x'] = $this->graph_x;
		$_SESSION['graph_y'] = $this->graph_y;
		$_SESSION['graph_x1'] = $this->graph_x1;
		$_SESSION['graph_y1'] = $this->graph_y1;
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
	<title>ДиВМ №4</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script-3.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №4 по ДиВМ</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых значений</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new lab4();
			?>
			</div>
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<img src="integral.png"><br>
		<label for="a">Значение А:</label> <input name="a" value="-10"><br>
		<label for="b">Значение В:</label> <input name="b" value="10"><br>
		<label for="n">Количество случайных точек:</label> <input name="n" id="n-mer" type="number" min="5" value="100000"><br>
		<br><br>
		<input type="hidden" name="method" value="method_lab4">
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>