<?
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
class matrix {
	private $method; //вызываемый метод
	private $a; //матрица коэффициентов
	private $c; //матрица свободных членов
	private $n; //мерность матрицы
	private $shag = -1; //текущий шаг обработки
	private $rang = 0; //ранг матрицы
	private $eps = 0.000001; //точность решения
	private $msg = '';
	private $color = "red";
	private $x = array(); //решения системы
	private $L, $y; // для Холецкого
	
	function __construct($n) {
		$this->n = $n;
		$this->method = $_POST['method'];
		if (method_exists("matrix", $this->method)) {
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
		// заполняем матрицу a числами
		$this->a = $_POST['a'];
		for ($i=0; $i<$this->n; $i++) {
			for ($j=0; $j<$this->n; $j++) {
				$this->a[$i][$j] = floatval($this->a[$i][$j]);
			}
		}
		// заполняем матрицу с
		$this->c = $_POST['c'];
		for ($i=0; $i<$this->n; $i++) {
			$this->c[$i] = floatval($this->c[$i]);
		}
		$this->otris_shag();
	}
	
	public function printMsg() {
		?>
		<script>$('body').popup("<?=$this->color?>", "<?=$this->msg?>");</script>
		<?	
	}
	
	// определение, совместна ли СЛАУ
	private function isSovm() {
		if ($this->rang == $this->n) 
			return true;
		else
			return false;
	}
	
	// определение, ошибочна ли СЛАУ
	private function isStupid() {
		// провека на выражения вида 2 = 0
		for ($str = 0; $str < $this->n; $str++) {
			$leftIsNull = true;
			for ($i = 0; $i < $this->n; $i++) {
				if (round($this->a[$str][$i],5) != 0) {
					$leftIsNull = false;
					break;
				}
			}
			if ($leftIsNull && $this->c[$str]) 
				return true;
		}
		return false;
	}
	
	// получение ранга матрицы А
	private function getRang() {
		for ($i = 0; $i < $this->n && round($this->a[$i][$i],5); $i++, $this->rang++);
	}
	
	// метод Гаусса
	private function method_hauss() {
		$this->msg = "Метод Гаусса: ";
		$this->HaussFirstStep();
		$this->getRang();
		echo "<h4>Ранг матрицы - ".$this->rang."</h4><br>";
		// если система совместна
		if ($this->isSovm()) {
			$this->HaussSecondStep();
			$this->msg .= "Система имеет единственное решение";
			$this->color = "green";
		}
		else {
			if ($this->isStupid()) {
				$this->msg .= "Система не имеет решений";
			}
			else {
				$this->msg .= "Система имеет бесконечное множество решений";
				$this->color = "orange";
			}
		}
	}
	
	// первый этап преобразований для метода Гаусса
	private function HaussFirstStep() {
		echo "<h4>Этап 1 - приведение к ступенчатому виду</h4><br>";
		// переносим строки в каждую позицию по очереди
		for ($obr_str = 0; $obr_str < $this->n; $obr_str++) {
			// ищем среди всех строк, еще не использованных
			for ($str = $obr_str; $str<$this->n; $str++) {
				// если текущая ячейка ненулевая
				if ($this->a[$str][$obr_str]) {
					// меняем строки местами
					$temp = $this->a[$str];
					$this->a[$str] = $this->a[$obr_str];
					$this->a[$obr_str] = $temp;
					$temp = $this->c[$str];
					$this->c[$str] = $this->c[$obr_str];
					$this->c[$obr_str] = $temp;
					// вычитаем искомую строку с множителем от всех следующих
					for ($i = $obr_str + 1; $i < $this->n; $i++) {
						$koef = $this->a[$i][$obr_str] / $this->a[$obr_str][$obr_str];
						for ($j=0; $j<$this->n; $j++) {
							$this->a[$i][$j] -= $koef * $this->a[$obr_str][$j];
						}
						$this->c[$i] -= $koef * $this->c[$obr_str];
					}
					// прерываем поиск подходящей строки
					break;
				}
			}
			// выводим полученную матрицу на экран
			$this->otris_shag();
		}
	}
	
	// второй этап преобразований для метода Гаусса
	private function HaussSecondStep() {
		echo "<h4>Этап 2 - расчет значений переменных</h4><br>";
		for ($tek_str = $this->n - 1; $tek_str >=0; $tek_str--) {
			// считаем текущую переменную
			$this->x[$tek_str] = $this->c[$tek_str] / $this->a[$tek_str][$tek_str];
			$this->c[$tek_str] /= $this->a[$tek_str][$tek_str];
			$this->a[$tek_str][$tek_str] = 1;
			// удаляем ее из предыдущих строк
			for ($i = 0; $i < $tek_str; $i++) {
				$this->c[$i] -= $this->a[$i][$tek_str] * $this->x[$tek_str];
				$this->a[$i][$tek_str] = 0;
			}
		}
		$this->otris_shag(false);
	}
	
	// метод Холецкого
	private function method_holeck() {
		// подготовка
		$this->msg = "Метод Холецкого: ";
		for ($i = 0; $i<$this->n; $i++) {
			for ($j = 0; $j<$this->n; $j++) 
				$this->L[$i][$j] = 0;
			$this->y[$i] = 0;
		}
		if ($this->isHoleck()) {
			if ($this->HoleckL()) {
				$this->printMatr($this->L);
				$this->color = "green";
				$this->msg .= "Система имеет решение";
				$this->HoleckY();
				$this->ZeidelOtris($this->y, 'y');
				$this->HoleckX();
				$this->ZeidelOtris($this->x);
			}
			else {
				$this->msg .= "Система не положительно определенная, решения нет, либо корни комплексные";
			}
		}
		$this->printMsg();
	}
	
	// проверка, подходит ли матрица под метод Холецкого
	private function isHoleck() {
		// проверим на симметричность
		for ($i=0; $i<$this->n; $i++) {
			for ($j=0; $j<$i; $j++) {
				if ($this->a[$i][$j] != $this->a[$j][$i]) {
					$this->msg .= "Матрица несимметрична, решения нет";
					return false;
				}
			}
		}
		return true;
	}
	
	private function printMatr($matr) {
		?>
		<h4>Матрица L</h4>
		<table>
		<?
		for ($i=0; $i<count($matr); $i++) {
			?><tr><?
			for ($j=0; $j<count($matr[$i]); $j++) {
				echo "<td>".$matr[$i][$j]."&nbsp;&nbsp;&nbsp;</td>";
			}
			?></tr><?
		}
		?>
		</table>
		<?
	}
	
	// расчет матрицы L
	private function HoleckL() {
		for ($i = 0; $i<$this->n; $i++) {
			$sum = 0;
			
			for ($j = 0; $j<$i; $j++) {
				$sum += $this->L[$i][$j] * $this->L[$i][$j];
			}
			if ($this->a[$i][$i] - $sum < 0) {
				return false;
			}
			$this->L[$i][$i] = sqrt($this->a[$i][$i] - $sum);
			
			for ($j = $i+1; $j<$this->n; $j++) {
				$sum = 0;
				for ($k = 0; $k<$i; $k++) {
					$sum += $this->L[$j][$k] * $this->L[$i][$k];
				}
				$this->L[$j][$i] = ($this->a[$j][$i] - $sum) / $this->L[$i][$i];
			}
		}
		return true;
	}
	
	// расчет y
	private function HoleckY() {
		for ($i=0; $i<$this->n; $i++) {
			$sum = 0;
			for ($j=0; $j<$i; $j++) {
				$sum += $this->L[$i][$j] * $this->y[$j];
			}
			$this->y[$i] = ($this->c[$i] - $sum) / $this->L[$i][$i];
		}
	}
	
	// расчет X
	private function HoleckX() {
		for ($i=$this->n-1; $i>=0; $i--) {
			$sum = 0;
			for ($j=$this->n-1; $j>=$i; $j--) {
				$sum += $this->L[$j][$i] * $this->x[$j];
			}
			$this->x[$i] = ($this->y[$i] - $sum) / $this->L[$i][$i];
		}
	}
	
	// метод Зейделя
	private function method_zeidel() {
		$this->msg = "Метод Зейделя: ";
		if ($this->isZeidelSovm()) {
			$this->ZeidelIter();
			$this->ZeidelOtris($this->x);
			$this->msg .= "Система имеет решение";
			$this->color = "green";
		}
		$this->printMsg();
	}
	
	// проверка на совместность
	private function isZeidelSovm() {
		for ($i = 0; $i<$this->n; $i++) {
			$sum = 0;
			for ($j = 0; $j<$this->n; $j++) {
				if ($j != $i)
					$sum += abs($this->a[$i][$j]);
				if ($sum >= abs($this->a[$i][$i])) {
					$this->msg .= 'Система несовместна, решений нет';
					return false;
				}
			}
		}
		for ($j = 0; $j<$this->n; $j++) {
			$sum = 0;
			for ($i = 0; $i<$this->n; $i++) {
				if ($j != $i)
					$sum += abs($this->a[$i][$j]);
				if ($sum >= abs($this->a[$i][$i])) {
					$this->msg .= 'Система несовместна, решений нет';
					return false;
				}
			}
		}
		return true;
	}
	
	// итерация по Зейделю
	private function ZeidelIter() {
		// подготовим $x
		for ($i=0; $i<$this->n; $this->x[$i++] = 0);
		while (true) {
			$razn = 0;
			for ($i=0; $i<$this->n; $i++) {
				$sum = 0;
				for ($j=0; $j<$this->n; $j++) {
					if ($i != $j)
						$sum += $this->a[$i][$j] * $this->x[$j];
				}
				$tek = $this->x[$i];
				$this->x[$i] = ($this->c[$i] - $sum) / $this->a[$i][$i];
				$razn = abs($this->x[$i]) - abs($tek);
			}
			if ($razn < $this->eps)
				return true;
		}
	}
	
	private function ZeidelOtris($x, $let = 'x') {
		?>
		<h4>Решение системы</h4>
		<table>
		<?
		for ($i=0; $i<$this->n; $i++) {
			?>
			<tr>
			<?
			echo "<td>$let<sub>".($i+1)."</sub></td><td> = ".$x[$i]."</td>";
			?>
			</tr>
			<?
		}
		?>
		</table>
		<?
	}
	
	// печать промежуточной матрицы
	private function otris_shag($podsvet = true) {
		?>
		<h4>Шаг <?=++$this->shag?></h4>
		<table style="text-align:right;" cellspacing="0">
		<?
		for ($i=0; $i<$this->n; $i++) {
			echo "<tr";
			if ($i < $this->shag && $podsvet)
				echo " class='podsvet'";
			echo ">";
			$bool = false;
			for ($j=0; $j<$this->n; $j++) {
				?>
				<td>
				<? 
				$a = $this->a[$i][$j];
				if (round($a,3)) {
					if ($a > 0 && $j && $bool) 
						echo "+";
					$bool = true;
					if (round($a, 3) != 1) {
						echo round($a,3);
						?>*<? } 
					?>x<sub><?=$j+1?></sub><?
				}
				if ($j == $this->n - 1 && !$a && !$bool)
					echo "0";
				echo "</td>";
			}
			echo "<td align='left'>=".round($this->c[$i],3)."</td>";
			echo "</tr>";
		}
		?>
		</table><br>
		<?
	}
}


// ======================================= PAGE

?>
<head>
	<title>Лабораторная работа №1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery.min.js"></script>
	<script src="script.js"></script>
</head>
<body id="top">
	<h1>Лабораторная работа №1 по ДиВМ</h1>
	<a href="#new" id="set-new"><h2 <? if (isset($_POST['accept'])) {?>style="border-bottom-color:#036;"<? }?>>Задание новой СЛАУ</h2></a>
	<? if (isset($_POST['accept'])) {?><a href="#resh" id="set-resh"><h2>Решение СЛАУ</h2></a><? }?>
	<?
	if (isset($_POST['accept'])) {
		?>
		<div id="accept-cont">
			<div id="accept">
			<?
			$matr = new matrix($_POST['n-mer']);
			?>
			</div>
			<input type="button" id="hide-accept" value="Скрыть" class="button"> <input type="button" id="show-accept" value="Показать" class="button">
		</div>
		<?
	}
	?>
	<form action="" id="new" method="post" <? if (isset($_POST['accept'])) {?> style="display:none;"<? }?>>
		<label for="n-mer">Размерность матрицы:</label> <input name="n-mer" id="n-mer" type="number" min="1" value="3"> <input type="button" id="table_but" value="Сгенерировать матрицу" class="button"> <input type="button" id="gener_but" value="Заполнить случайными числами" class="button">
		<br>
		<label for="method">Выберите метод:</label>
		<select name="method">
			<option value="method_hauss" selected>1. Гаусса</option>
			<option value="method_holeck">2. Холецкого</option>
			<option value="method_zeidel">3. Зейделя</option>
		</select>
		<div id="table" style="display:none"></div>
		<br><input type="submit" name="accept" value="Решить" class="button" />
	</form><br>
	<? if (isset($_POST['accept'])) {  $matr->printMsg();  }?>
	<h1>Разработчик программы: студент группы 051004 Дубко Никита</h1>
</body>