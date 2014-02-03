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
	
	private $count = 0;
	private $rastTable = array();
	private $max = 0;	
		
	function __construct() {
		$this->timer = time();
		
		$this->count = $_POST['kolvo'];
		$this->rastTable = $_POST['x'];
		
		$this->OtrisTable();
		
		$this->DoIT();
		$this->DoITMax();
		
		$this->msg .= ", время - ".(time() - $this->timer)." c";
		
		?><br> 
		
		<div style="clear:both"></div>
		<?
	}

	
	private function DoIT() {
		$rast = $this->rastTable;
		$tree = array();
		
		// соханяем номера вершин
		for ($i=0; $i< $this->count; $i++) {
			$tree[$i] = $i;
		}
		
		// изменяем 0 на максимуму для простоты поиска минимума
		$max = 0;
		foreach ($rast as $elem) {
			foreach ($elem as $value) {
				if ($value > $max) {
					$max = $value;
				}
			}
		}
		$max += 1;
		foreach ($rast as $key1 => $elem) {
			foreach ($elem as $key2 => $value) {
				if ($key1 == $key2) {
					$rast[$key1][$key2] = $max;
				}
			}
		}
		
		
		$this->x = 1;
		
		// выполняем, пока не создадим одну вершину
		while (count($tree) > 1) {
			$min = $max;
			$iskI = -1;
			$iskJ = -1;
			foreach ($tree as $key1 => $value1) {
				foreach ($tree as $key2 => $value2) {
					// если один и тот же элемент, пропускаем
					if ($key1 == $key2)
						continue;
					$tempMin = $this->inf($value1, $value2);
					if ($min > $tempMin) {
						$min = $tempMin;
						$iskI = $key1;
						$iskJ = $key2;
					}
				}
			}
			
			if ($min != $max) {
				// переносим найденные вершины под нового родителя
				$tree[$iskJ] = array($tree[$iskI], $tree[$iskJ]);
				unset($tree[$iskI]); 
				if (!is_array($tree[$iskJ][0])) {
					$tree[$iskJ]['x0'] = $this->x++;
				}
				if (!is_array($tree[$iskJ][1])) {
					$tree[$iskJ]['x1'] = $this->x++;
				}
			}
			else 
				break;
		}
		
		$tree = reset($tree);
		
		$tree = $this->setCoordsY($tree);
			
		//print_otlad($tree);
		
		$tree = $this->setCoordsX($tree);
		
		$_SESSION['mas'] = $tree;
		$_SESSION['max'] = $this->count;
		
		?>		
		<h1 style="clear:both">Критерий минимума</h1>
		<img src="image-graph-6.php?id=<?=rand()?>">
		<?
	}
	
	private function DoITMax() {
		$rast = $this->rastTable;
		$tree = array();
		
		// сохраняем номера вершин
		for ($i=0; $i< $this->count; $i++) {
			$tree[$i] = $i;
		}
		
		// изменяем 0 на максимуму для простоты поиска минимума
		$max = 0;
		foreach ($rast as $elem) {
			foreach ($elem as $value) {
				if ($value > $max) {
					$max = $value;
				}
			}
		}
		
		$this->x = 1;
		
		// выполняем, пока не создадим одну вершину
		while (count($tree) > 1) {
			$min = 0;
			$iskI = -1;
			$iskJ = -1;
			foreach ($tree as $key1 => $value1) {
				foreach ($tree as $key2 => $value2) {
					// если один и тот же элемент, пропускаем
					if ($key1 == $key2)
						continue;
					$tempMin = $this->infMax($value1, $value2);
					if ($min < $tempMin) {
						$min = $tempMin;
						$iskI = $key1;
						$iskJ = $key2;
					}
				}
			}
			
			if ($min != 0) {
				// переносим найденные вершины под нового родителя
				$tree[$iskJ] = array($tree[$iskI], $tree[$iskJ]);
				unset($tree[$iskI]); 
				if (!is_array($tree[$iskJ][0])) {
					$tree[$iskJ]['x0'] = $this->x++;
				}
				if (!is_array($tree[$iskJ][1])) {
					$tree[$iskJ]['x1'] = $this->x++;
				}
			}
			else 
				break;
		}
		
		$tree = reset($tree);
		
		$this->max = 0;
		$tree = $this->setCoordsYMax($tree);
			
		//print_otlad($tree);
		
		$tree = $this->setCoordsX($tree);
		
		$_SESSION['mas1'] = $tree;
		$_SESSION['max1'] = $this->count;
		$_SESSION['maxmax'] = $this->max;
		
		?>
		<h1>Критерий максимума</h1>
		<img src="image-graph-6-max.php?id=<?=rand()?>">
		<?
	}
	
	private function setCoordsX($a) {
		if (!is_array($a[0])) {
			$a['x0'] = $a['x0'];
		}
		else {
			$a[0] = $this->setCoordsX($a[0]);
		}
		if (!is_array($a[1])) {
			$a['x1'] = $a['x1'];
		}
		else {
			$a[1] = $this->setCoordsX($a[1]);
		}
		
		if (isset($a[0]['x0']) && isset($a[0]['x1'])) {
			$a['x0'] = ($a[0]['x0'] + $a[0]['x1']) / 2.0;
		}
		if (isset($a[1]['x0']) && isset($a[1]['x1'])) {
			$a['x1'] = ($a[1]['x0'] + $a[1]['x1']) / 2.0;
		}
		
		return $a;
	}
	
	private function setCoordsY($a) {
		if (is_array($a)) {
			$a['y'] = $this->inf($a[0],$a[1]);
			$a[0] = $this->setCoordsY($a[0]);
			$a[1] = $this->setCoordsY($a[1]);
		}
		
		return $a;
	}
	
	private function setCoordsYMax($a) {
		if (is_array($a)) {
			$a['y'] = 100 - $this->infMax($a[0],$a[1]);
			if ($a['y'] > $this->max) {
				$this->max = $a['y'];
			}
			$a[0] = $this->setCoordsYMax($a[0]);
			$a[1] = $this->setCoordsYMax($a[1]);
		}
		
		return $a;
	}
	
	// функция нахождения минимума по всей ветке
	private function inf($a, $b) {
		if (is_array($a)) {
			return min($this->inf(reset($a), $b), $this->inf(next($a), $b));
		}
		if (is_array($b)) {
			return min($this->inf(reset($b), $a), $this->inf(next($b), $a));
		}
		return ($this->rastTable[$a][$b]);
	}
	
	private function infMax($a, $b) {
		if (is_array($a)) {
			return max($this->infMax(reset($a), $b), $this->infMax(next($a), $b));
		}
		if (is_array($b)) {
			return max($this->infMax(reset($b), $a), $this->infMax(next($b), $a));
		}
		return ($this->rastTable[$a][$b]);
	}
	
	// отрисовка таблицы расстояний
	private function OtrisTable() {
		$n = $this->count;	
	
		$str = "<table class='table'><tr><td></td>";
		for ($i=0; $i<$n; $i++) {
			$str .= "<th>x<sub>" . ($i+1) . "</sub></th>";
		}
		$str .= "</tr>";
		for ($i=0; $i<$n; $i++) {
			$str .= "<tr><th>";
			$str .= "x<sub>" . ($i+1) . "</sub></th>";
			for ($j=0; $j<$n; $j++)
				$str .= "<td>".$this->rastTable[$i][$j]."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		
		echo $str;
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
	<title>МиАПР №6</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script-6.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №6 по МиАПР</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание нового набора</h2></a>
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
		<label for="core">Количество атомов: </label>
		<input type="number" min="1" name="kolvo" value="4" id="kolvo"><br><br>
		<label for="table">Таблица расстояний между атомами: </label><br>
		<div id="table"></div>
		<input type="button" id="table_but" value="Сгенерировать матрицу" class="button"> <input type="button" id="gener_but" value="Заполнить случайными числами" class="button"><br>
		<br><br>
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>