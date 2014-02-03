<?
	ini_set('memory_limit', '512M');
	ini_set("max_execution_time", "3600");
	include_once("image.php");
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
	
	function __construct($pointCount, $core) {
		$this->timer = time();
		$this->pointCount = intval($pointCount);
		$this->core = intval($core);
		$this->method = $_POST['method'];
		if (method_exists("miapr", $this->method)) {
			$method = $this->method;
			$this->$method();
		}
		else {
			echo "<p class='red'>Некорректное задание метода</p>";
		}
		$this->msg .= ", время - ".(time() - $this->timer)." c";
	}
	
	// метод К средних
	private function method_KSr() {
		$this->msg = 'Точек - '.$this->pointCount.', классов - '.$this->core;
		
		$this->KSr_prepare();
		$this->Otris();
		$this->Resh();
	}
	
	// подготовка данных
	private function KSr_prepare() {
		$this->genPoints();
		$this->genCores();
	}
	
	// комбинированный метод
	private function method_comb() {
		$this->method_maksimin();
		?>
		<h1>Переход с самообучения на обучение с учителем</h1><br>
		<?
		$this->Resh();
	}
	
	// метод Максимина
	private function method_maksimin() {
		$this->msg = 'Точек - '.$this->pointCount;
		
		$this->maksimin_prepare();
		$this->setClasses();
		$this->Otris();
		
		while ($this->maksimin_step()) {
			$this->setClasses();
			$this->Otris();
		}
		$this->msg .= ', классов - '.$this->core;
	}
	
	// подготовительные действия для максимина
	private function maksimin_prepare() {
		$this->core = 1;
		$this->genPoints();
		$this->genCores();
		
		// второе ядро
		$maxRast = 0;
		$indMax = 0;
		$c = $this->points[$this->corePoints[0]];
		// ищем максимально удаленную книжку
		for ($i=0; $i<$this->pointCount; $i++) {
			$point = $this->points[$i];
			$rast = sqrt($this->EvklRast($point['x'],$point['y'], $c['x'],$c['y']));
			if ($rast > $maxRast) {
				$indMax = $i;
				$maxRast = $rast;
			}
		}
		// назначаем точку ядром
		$this->points[$indMax]['isCore'] = true;
		$this->points[$indMax]['class'] = 1;
		$this->corePoints[1] = $indMax;
		$this->core++;
	}
	
	// определение нового ядра, если оно есть
	private function maksimin_step() {
		$bool = false;
		
		// считаем сумму расстояний между ядрами
		$sumRast = 0;
		$rastKol = 0;
		for ($j=0; $j<$this->core; $j++) {
			for ($k=$j+1; $k<$this->core; $k++) {
				$p1 = $this->points[$this->corePoints[$j]];
				$p2 = $this->points[$this->corePoints[$k]];
				$sumRast += sqrt($this->EvklRast($p1['x'], $p1['y'], $p2['x'], $p2['y']));
				$rastKol++;
			}
			$maxRast[$j]['rast'] = 0;
			$maxRast[$j]['ind'] = 0;
		}
		$halfOfRast = ($sumRast / $rastKol) / 2;
		
		// ищем самую удаленную точку
		for ($i=0; $i<$this->pointCount; $i++) {
			$point = $this->points[$i];
			$core = $this->points[$this->corePoints[$point['class']]];
			$rast = sqrt($this->EvklRast($core['x'], $core['y'], $point['x'], $point['y']));
			if ($rast > $maxRast[$point['class']]['rast']) {
				$maxRast[$point['class']]['rast'] = $rast;
				$maxRast[$point['class']]['ind'] = $i;
			}
		}
		
		$rast = 0;
		$ind = 0;
		for ($i=0; $i<$this->core; $i++) {
			if ($rast < $maxRast[$i]['rast']) {
				$rast = $maxRast[$i]['rast'];
				$ind = $maxRast[$i]['ind'];
			}
		}
		
		// если условие создания нового ядра прокатывает
		if ($rast > $halfOfRast) {
			// назначаем новое ядро
			$bool = true;
			$this->corePoints[$this->core++] = $ind;
			$this->points[$ind]['class'] = $this->core - 1;
			$this->points[$ind]['isCore'] = true;
		}
		
		return $bool;
	}
	
	// генерация точек
	private function genPoints() {
		for ($i=0; $i<$this->pointCount; $i++) {
			$this->points[$i]['x'] = abs(rand() + rand() - rand()) % 600;
			$this->points[$i]['y'] = abs(rand() + rand() - rand()) % 350;
			$this->points[$i]['class'] = -1;
			$this->points[$i]['isCore'] = false;
		}
	}
	
	// генерация ядер
	private function genCores() {
		for ($i=0; $i<$this->core; $i++) {
			for ($c = rand() % $this->pointCount; $this->points[$c]['isCore']; $c = rand() % $this->pointCount);
			$this->points[$c]['isCore'] = true;
			$this->corePoints[$i] = $c;
			$this->points[$c]['class'] = $i;
		}
	}
	
	// решение задачи
	private function Resh() {
		$needComplete = true;
		while ($needComplete) {
			$this->setClasses();
			$needComplete = $this->setCores();
			$this->Otris();
		}
	}
	
	// определение принадлежности точек к классу
	private function setClasses() {
		for ($i=0; $i<count($this->points); $i++) {
			$min = 1000000;
			$class = -1;
			for ($j=0; $j<count($this->corePoints); $j++) {
				$core = $this->points[ $this->corePoints[$j] ];
				$point = $this->points[$i];
				if ($this->EvklRast( $core['x'], $core['y']
									, $point['x'], $point['y']) < $min) {
					$class = $core['class'];
					$min = $this->EvklRast( $core['x'], $core['y']
									, $point['x'], $point['y']);
				}
			}
			$this->points[$i]['class'] = $class;
		}
	}
	
	// переопределение ядер
	private function setCores() {
		$needComplete = false;
		// сохраним значения ядер для сравнения
		$oldCores = $this->corePoints;
		// случайным образом заполняем массивы граничных точек
		for ($i=0; $i<count($this->corePoints); $i++) {
			$coordSum[$i]['x'] = $coordSum[$i]['y'] = $coordSum[$i]['count'] = 0;
		}
		// находим суммы координат
		for ($i=0; $i<count($this->points); $i++) {
			$coordSum[$this->points[$i]['class']]['x'] += $this->points[$i]['x'];
			$coordSum[$this->points[$i]['class']]['y'] += $this->points[$i]['y'];
			$coordSum[$this->points[$i]['class']]['count']++;
			$this->points[$i]['isCore'] = false;
		}
		// вычисляем координаты центров кластеров
		for ($i=0; $i<count($this->corePoints); $i++) {
			$center[$i]['x'] = $coordSum[$i]['x'] / $coordSum[$i]['count'];
			$center[$i]['y'] = $coordSum[$i]['y'] / $coordSum[$i]['count'];
			$center[$i]['rast'] = 100000;
		}
		// переопределяем ядра кластеров
		for ($i=0; $i<count($this->points); $i++) {
			$point = $this->points[$i];
			$core = $center[$this->points[$i]['class']];
			if ($core['rast'] > $this->EvklRast($point['x'], $point['y'], $core['x'], $core['y'])) {
				$this->corePoints[$this->points[$i]['class']] = $i;
				$center[$this->points[$i]['class']]['rast'] = $this->EvklRast($point['x'], $point['y'], $core['x'], $core['y']);
			}
		}
		if ($oldCores != $this->corePoints) {
			$needComplete = true;
		}
		return $needComplete;
	}
	
	// расстояние между двумя точками
	private function EvklRast($x1, $y1, $x2, $y2) {
		return /*sqrt*/(($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2));
	}
	
	private function Otris() {
		$obj = new ImageGraph($this->points, $this->corePoints, $this->shag);
		?>
		<h4>Шаг <?=$this->shag?></h4>
		<a class="lightbox-enabled" rel="lightbox-galery" href="image<?=$this->shag?>.png"><img src="images/image<?=$this->shag++?>.png"></a>
		<?
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
	<title>МиАПР №2</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="jquery.lightbox.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №2 по МиАПР</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых классов</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new miapr($_POST['count'], $_POST['core']);
			?>
			</div>
			<!--<input type="button" id="next-img" value="Следующее" class="button" style="position:fixed; bottom:15px; right:35px; z-index:1000;"> -->
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="method">Выберите метод: </label>
		<select name="method">
			<option value="method_KSr">1. Метод К средних</option>
			<option value="method_maksimin" selected>2. Метод Максимина</option>
			<option value="method_comb">3. Комбинированный метод</option>
		</select><br><br> 
		<label for="count">Количество точек: </label>
		<input type="number" min="1" name="count" value="5000"><br><br>
		<label for="core">Количество классов: </label>
		<input type="number" min="1" name="core" value="1"><br><br>
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>