<?
	session_start();
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
	private $color = 'green';
	private $msg = 'Решение задачи прошло успешно';
	private $ver1, $ver2; //заданные вероятности
	
	function __construct() {
		$this->timer = time();
		$this->ver1 = floatval($_POST['ver1']);
		$this->ver2 = floatval($_POST['ver2']);
		?>
		<p><strong>Вероятность 1:</strong> <?=$this->ver1?></p>
		<p><strong>Вероятность 2:</strong> <?=$this->ver2?></p>
		<?
		$this->doIt();
		$this->msg .= ", время - ".(time() - $this->timer)." c";
	}
	
	private function doIt() {
		// генерация массивов
		$masX1 = $masX2 = array();
		for ($i=0; $i<100; $i++) {
			array_push($masX1, rand() % 600);
			array_push($masX2, rand() % 600 + 400);
		}
		sort($masX1);
		sort($masX2);
		for ($i=0; $i<=1000; $i++) {
			$masX[$i] = $i;
		}
		
		$masP1 = $this->genP($masX1);
		$masP2 = $this->genP($masX2);
		
		$masY1 = $this->genY($masP1, $this->ver1);
		$masY2 = $this->genY($masP2, $this->ver2);
		
		// на отрисовку 
		$_SESSION['graph_x'] = $masX;
		$_SESSION['graph_x1'] = $masX;
		$_SESSION['graph_y'] = $masY1;		
		$_SESSION['graph_y1'] = $masY2;
		
		$sum = 0;
		for ($i=0; $i<=1000; $i++) {
			$sum += $masY1[$i];
		}
		// понеслась рассчитывать интеграл :)
		for ($i=0; $i<=1000; $i++) {
			if ($masY2[$i] >= $masY1[$i]) 
				break;
		}
		$x = $i;
		$int1 = $int2 = $int = 0;
		// левую сторону
		for ($i=0; $i<$x; $i++) {
			$int1 += $masY2[$i];
		}
		// правую сторону
		for ($i=$x; $i<=1000; $i++) {
			$int2 += $masY1[$i];
		}
		$int = $int1 + $int2;
		
		?>
		<h4>Зона ложной тревоги: <?=$int1/$sum?></h4>
		<h4>Зона пропуска обнаружения: <?=$int2/$sum?></h4>
		<h4>Суммарная ошибка классификации: <?=$int/$sum?></h4>
		<img src="image-graph-2.php?<?=rand()?>">
		<?
	}
	
	// расчет плотности вероятности
	private function genP($masX) {
		$sigma = $this->sigma($masX);
		$mu = $this->mu($masX);
		for ($i=0; $i<=1000; $i++) {
			$x = $i;
			$masY[$i] = 1/($sigma * sqrt(2*3.14156))
						 * exp(- 0.5 * pow( ($x-$mu)/$sigma, 2) );
		}
		return $masY;
	}
	// расчет Y по вероятностям
	private function genY($masX, $ver) {
		for ($i=0; $i<count($masX); $i++) {
			$masY[$i] = $masX[$i] * $ver;
		}
		return $masY;
	}
	
	// рассчет мат. ожидания
	private function mu($masX) {
		$sum = 0;
		for ($i=0; $i<count($masX); $i++) {
			$sum += $masX[$i];
		}
		return $sum / count($masX);
	}
	
	// рассчет среднеквадр. отклонения
	private function sigma($masX) {
		$sigma = $this->mu($masX);
		$sum = 0;
		for ($i=0; $i<count($masX); $i++) {
			$sum += pow($masX[$i] - $sigma, 2);
		}
		return sqrt($sum / count($masX));
	}
	
	// расстояние между двумя точками
	private function EvklRast($x1, $y1, $x2, $y2) {
		return /*sqrt*/(($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2));
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
	<title>МиАПР №3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="jquery.lightbox.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №3 по МиАПР</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых классов</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new miapr();
			?>
			</div>
			<!--<input type="button" id="next-img" value="Следующее" class="button" style="position:fixed; bottom:15px; right:35px; z-index:1000;"> -->
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="ver1">Вероятность первой величины: </label>
		<input type="text" name="ver1" value="0.25" id="ver1"><br><br>
		<label for="ver2">Вероятность второй величины: </label>
		<input type="text" name="ver2" value="0.75" id="ver2" readonly><br><br>
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>