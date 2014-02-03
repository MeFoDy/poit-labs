<?	
	define("LEFT_BORD", 180);
	ini_set('memory_limit', '512M');
	ini_set("max_execution_time", "3600");
	include_once("image-2.php");
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
	private $coresCount, $prizn, $kolvo;
	private $x, $c = 3, $w, $d;
	
	function __construct($pointCount) {
		$this->timer = time();
		$this->coresCount = intval($pointCount);
		$this->prizn = intval($_POST['priznak']);
		$this->kolvo = intval($_POST['kolvo']);
		$this->x = $_POST['x'];
		
		for ($i = 0; $i<$this->coresCount; $i++) {
			for ($j = 0; $j<=$this->prizn; $j++) {
				$this->w[$i][$j] = 0;
			}
		}
		for ($i = 0; $i<$this->coresCount; $i++) {
			for ($j = 0; $j<$this->kolvo; $j++) {
				$this->x[$i][$j][$this->prizn] = 1;
			}
		}
		$this->prizn += 1;
		$this->perceptron();
		$this->prizn -= 1;
		$this->msg .= ", время - ".(time() - $this->timer)." c";
		
		?><br>
		<strong>Тестовое значение:</strong> x = (<?
		for ($i=0; $i<$this->prizn; $i++) {
			if ($i != 0) echo ", ";
			echo "<input type=\"number\" name=\"x$i\" id=\"x$i\" class='x' style=\"width:40px\">";
		}
		?>) 
		<input type="button" id="set-point" value="Определить" class="button">
		<script>
		var w = [<? for ($i=0; $i<$this->coresCount; $i++) {
						if ($i<>0) echo ",";
						echo "[";
						
						for ($j=0; $j<=$this->prizn; $j++) {
							if ($j<>0) echo ",";
							echo $this->w[$i][$j];
						}
						echo "]";
					} ?>];
		var countP = <?=$this->prizn?>;
		var countW = <?=$this->coresCount?>;
		</script>
		<div style="clear:both"></div>
		<?
	}
	
	// метод 
	private function perceptron() {
		$this->msg = 'Классов - '.$this->coresCount;
		
		$flag = true;
		$w = $this->w;
		$c = $this->c;
		$atata = 0;
		// пока не выполним итерацию без наказаний
		while ($flag) {
			$flag = false;
			// для каждой точки обучающей выборки
			for ($i=0; $i<$this->coresCount; $i++) {
				for ($k=0; $k<$this->kolvo; $k++) {
					$x = $this->x[$i][$k];
					// рассчитаем D
					for ($j=0; $j<$this->coresCount; $j++) {
						$d[$j] = 0;
						for ($q=0; $q<$this->prizn; $q++) {
							$d[$j] += $w[$j][$q] * $x[$q];
						}
					}
					// проверяем, нужно ли наказывать
					$nakaz = false;
					$etalon = $d[$i];
					for ($j=0; $j<$this->coresCount; $j++) {
						// если нашли значение, большее эталона
						if ($i<>$j && $etalon <= $d[$j]) {
							// наказываем
							for ($q=0; $q<$this->prizn; $q++) {
								$w[$j][$q] -= $c * $x[$q];
							}
							$nakaz = true;
						}
					}
					// поощрение, если нужно
					if ($nakaz) {
						for ($q=0; $q<$this->prizn; $q++) {
							$w[$i][$q] += $c * $x[$q];
						}
						$flag = true;
					}
				}
			}
			
			$this->w = $w;
			if (!$flag) {
				if (!$this->proverka())
					$flag = true;
			}
			//if (abs(time() - $this->timer) > 2) $flag = false;
			$atata++;
			if ($atata > 500) {
				$this->color = 'red';
				$this->msg = 'Функция расходится';
				break;
			}
		}
		
		$this->printResh();
		
		$this->genPoints();
		$this->Otris();
	}
	
	// проверка мер на корректность
	private function proverka() {
		$w = $this->w;
		// для каждой точки обучающей выборки
		for ($i=0; $i<$this->coresCount; $i++) {
			for ($k=0; $k<$this->kolvo; $k++) {
				$x = $this->x[$i][$k];
				// рассчитаем D
				for ($j=0; $j<$this->coresCount; $j++) {
					$d[$j] = 0;
					for ($q=0; $q<$this->prizn; $q++) {
						$d[$j] += $w[$j][$q] * $x[$q];
					}
				}
				// проверяем, нужно ли наказывать
				$nakaz = false;
				$etalon = $d[$i];
				for ($j=0; $j<$this->coresCount; $j++) {
					// если нашли значение, большее эталона
					if ($i<>$j && $etalon <= $d[$j]) {
						return false;
					}
				}
			}
		}
		return true;
	}
	
	// печать решающих функций
	private function printResh() {
		?>
		<h4>Исходные данные:</h4><br>
		<?
		for ($i=0; $i<$this->coresCount; $i++) {
			for ($j=0; $j<$this->kolvo; $j++) {
				if ($j==0)
					echo "C<sub>" , ($i+1) , "</sub> = {";
				else 
					echo ", ";
				for ($k=0; $k<$this->prizn; $k++) {
					if ($k==0)
						echo "(";
					else 
						echo ",";
					echo $this->x[$i][$j][$k];
					if ($k==$this->prizn-1)
						echo ")";
				}
				if ($j==$this->kolvo-1)
					echo "}";
			}
			echo"<hr>";
		}
		$w = $this->w;
		?>
		<h4>Решающие функции:</h4>
		<table style="font-size:12px;"><tr><td>
		<?
		for ($i=0; $i<$this->coresCount; $i++) {
			echo "d<sub>" , $i+1 ,"</sub>(x) = ";
			for ($j=0; $j<$this->prizn; $j++) {
				if ($w[$i][$j] >= 0) 
					if ($j != 0)
						echo " + ";
					else echo "";
				else 
					echo " - ";
				echo abs($w[$i][$j]);
				if ($j<$this->prizn-1) 
					echo "*x<sub>" , $j+1 , "</sub>";
			}
			echo "<hr>";
		}
		?>
		</td></tr></table>
		<?
	}
		
	// расстояние между двумя точками
	private function EvklRast($x1, $y1, $x2, $y2) {
		return /*sqrt*/(($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2));
	}
	
	private function genPoints() {
		// ядра
		for ($i=0; $i<$this->coresCount; $i++) {
			$this->corePoints[$i]['x'] = $this->x[$i][0][0] + LEFT_BORD;
			$this->corePoints[$i]['y'] = $this->x[$i][0][1] + LEFT_BORD;
			$this->corePoints[$i]['class'] = $i;
		}
		// точки
		$shag = 0;
		for ($i= - LEFT_BORD; $i<= - LEFT_BORD + 360; $i+=3) {
			for ($j= - LEFT_BORD; $j<= - LEFT_BORD + 360; $j+=3) {
				$this->points[$shag]['x'] = $i + LEFT_BORD;
				$this->points[$shag]['y'] = $j + LEFT_BORD;
				$etalon = - pow(2,61);
				$class = -1;
				for ($k=0; $k<$this->coresCount; $k++) {
					$w = $this->w[$k];
					$sum = $w[0]*$i + $w[1]*$j + $w[2];
					if ($sum > $etalon) {
						$class = $k;
						$etalon = $sum;
					}
				}
				$this->points[$shag++]['class'] = $class;
			}
		}
	}
	private function Otris() {
		if ($this->prizn == 3) {
			$obj = new ImageGraph($this->points, $this->corePoints, $this->shag);
			?>
			<h4>Графическое распределение точек по классам</h4>
			<img src="images/image<?=$this->shag++?>.png" align="left">
			<?
		}
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
	<title>МиАПР №4</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="jquery.lightbox.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №4 по МиАПР</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новых классов</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new miapr($_POST['core']);
			?>
			</div>
			<!--<input type="button" id="next-img" value="Следующее" class="button" style="position:fixed; bottom:15px; right:35px; z-index:1000;"> -->
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="core">Количество классов: </label>
		<input type="number" min="2" name="core" value="3" id="core"><br><br>
		<label for="core">Количество объектов в классе: </label>
		<input type="number" min="1" name="kolvo" value="2" id="kolvo"><br><br>
		<label for="core">Количество признаков: </label>
		<input type="number" min="2" name="priznak" value="8" id="priznak"><br><br>
		<label for="table">Обучающая выборка: </label><br>
		<div id="table"></div>
		<input type="button" id="table_but" value="Сгенерировать матрицу" class="button"> <input type="button" id="gener_but" value="Заполнить случайными числами" class="button"><br>
		<br><br>
		<input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>